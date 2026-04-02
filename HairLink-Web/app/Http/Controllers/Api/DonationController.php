<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Auth::user()->donations()->with('user')->orderBy('created_at', 'desc')->get();
        return response()->json($donations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:donations',
            'hair_length' => 'required|string',
            'hair_color' => 'required|string',
            'treated_hair' => 'boolean',
            'address' => 'nullable|string',
            'reason' => 'nullable|string',
            'dropoff_location' => 'nullable|string',
            'appointment_at' => 'nullable|date',
        ]);

        $donation = Auth::user()->donations()->create($validated);

        // Record initial status in history
        $donation->statusHistories()->create([
            'status' => 'Submitted'
        ]);

        return response()->json($donation, 201);
    }

    public function show($reference)
    {
        $donation = Auth::user()->donations()
            ->where('reference', $reference)
            ->with(['statusHistories', 'user'])
            ->first();

        if (!$donation) {
            return response()->json(['message' => 'Donation not found'], 404);
        }

        return response()->json($donation);
    }

    public function updateStatus(Request $request, $reference)
    {
        $user = Auth::user();
        $query = Donation::where('reference_number', $reference);
        
        // If not staff/admin, they can only update their own (for legacy simulation, though we removed those buttons)
        if (!in_array($user->role, ['staff', 'admin'])) {
            $query->where('user_id', $user->id);
        }

        $donation = $query->firstOrFail();
        
        $validated = $request->validate([
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        if ($donation->status !== $validated['status']) {
            $donation->update(['status' => $validated['status']]);
            $donation->statusHistories()->create(['status' => $validated['status']]);

            if ($validated['status'] === 'Completed' && !$donation->certificate_no) {
                $donation->update([
                    'certificate_no' => 'CERT-' . date('Y') . '-' . substr($donation->reference, -6)
                ]);
            }
        }

        return response()->json($donation->load(['statusHistories', 'user']));
    }
}
