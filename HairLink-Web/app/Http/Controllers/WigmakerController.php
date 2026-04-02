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

        $tasks = WigProduction::where('wigmaker_id', $user->id)->get();
        return view('pages.wigmaker-dashboard', compact('tasks'));
    }

    public function taskDetail($taskCode)
    {
        $task = WigProduction::with('donation')->where('task_code', $taskCode)->firstOrFail();
        return view('pages.wigmaker-task-detail', compact('task'));
    }

    public function updateTask(Request $request, $taskCode)
    {
        $task = WigProduction::where('task_code', $taskCode)->firstOrFail();
        
        $validated = $request->validate([
            'status' => 'required|string|in:assigned,processing,completed',
            'notes' => 'required|string',
        ]);

        $task->update([
            'status' => $validated['status'],
        ]);

        // In a real app, we'd save the notes to a related history table here

        return response()->json(['message' => 'Task updated successfully', 'success' => true]);
    }
}
