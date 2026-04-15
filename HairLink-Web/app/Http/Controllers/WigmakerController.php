<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WigProduction;

class WigmakerController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect('/login');
        }

        $tasks = WigProduction::with('donation')->where('wigmaker_id', $user->id)->get();
        return view('pages.wigmaker-dashboard', compact('tasks'));
    }

    public function productionTasks(Request $request)
    {
        $user = $request->user();
        $tasks = WigProduction::with('donation')
            ->where('wigmaker_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $queuedCount = $tasks->where('status', 'assigned')->count();
        $inProgressCount = $tasks->where('status', 'processing')->count();
        $completedCount = $tasks->where('status', 'completed')->count();
            
        return view('pages.wigmaker-production-tasks', compact('tasks', 'queuedCount', 'inProgressCount', 'completedCount'));
    }

    public function taskDetail($taskCode)
    {
        $task = WigProduction::with(['donation', 'statusHistories'])
            ->where('task_code', $taskCode)
            ->firstOrFail();

        $histories = $task->statusHistories()->orderBy('created_at', 'desc')->get();

        return view('pages.wigmaker-task-detail', compact('task', 'histories'));
    }

    public function updateTask(Request $request, $taskCode)
    {
        $task = WigProduction::where('task_code', $taskCode)->firstOrFail();
        
        $validated = $request->validate([
            'status' => 'required|string|in:assigned,processing,completed',
            'notes' => 'nullable|string',
        ]);

        $task->update([
            'status' => $validated['status'],
        ]);

        $task->statusHistories()->create([
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        return response()->json(['message' => 'Task updated successfully', 'success' => true]);
    }
}
