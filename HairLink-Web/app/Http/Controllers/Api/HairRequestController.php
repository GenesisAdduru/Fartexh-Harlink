<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HairRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HairRequestController extends Controller
{
    public function index()
    {
        $requests = Auth::user()->hairRequests()->orderBy('created_at', 'desc')->get();
        return response()->json($requests);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:hair_requests',
            'contact_number' => 'nullable|string',
            'gender' => 'nullable|string',
            'story' => 'nullable|string',
            'additional_photo' => 'nullable|image|max:10240',
            'documents.*' => 'nullable|file|max:10240',
            'appointment_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('additional_photo')) {
            $path = $request->file('additional_photo')->store('requests/photos', 'public');
            $validated['additional_photo'] = $path;
        }

        if ($request->hasFile('documents')) {
            $docs = [];
            foreach ($request->file('documents') as $file) {
                $docs[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $file->store('requests/docs', 'public'),
                    'type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ];
            }
            $validated['documents'] = $docs;
        }

        $hairRequest = Auth::user()->hairRequests()->create($validated);

        // Record initial status in history
        $hairRequest->statusHistories()->create([
            'status' => 'Submitted'
        ]);

        return response()->json($hairRequest, 201);
    }

    public function show($reference)
    {
        $hairRequest = Auth::user()->hairRequests()
            ->where('reference', $reference)
            ->with('statusHistories')
            ->first();

        if (!$hairRequest) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        return response()->json($hairRequest);
    }

    public function updateStatus(Request $request, $reference)
    {
        $hairRequest = Auth::user()->hairRequests()->where('reference', $reference)->firstOrFail();
        
        $validated = $request->validate([
            'status' => 'required|string'
        ]);

        if ($hairRequest->status !== $validated['status']) {
            $hairRequest->update(['status' => $validated['status']]);
            $hairRequest->statusHistories()->create(['status' => $validated['status']]);
        }

        return response()->json($hairRequest->load('statusHistories'));
    }
}
