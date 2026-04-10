<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\HairRequest;
use App\Models\WigProduction;

class StaffController extends Controller
{
    public function dashboard()
    {
        $pendingDonations = Donation::where('status', 'Received')->count();
        $pendingRequests = HairRequest::where('status', 'Submitted')->count();
        $totalStock = Donation::where('status', 'Completed')->count();

        return view('pages.staff-dashboard', compact('pendingDonations', 'pendingRequests', 'totalStock'));
    }

    public function donorVerification()
    {
        $donations = Donation::with('user')->whereIn('status', ['Submitted', 'Received'])->get();
        return view('pages.staff-donor-verification', compact('donations'));
    }

    public function recipientVerification()
    {
        $requests = HairRequest::with('user')->whereIn('status', ['Submitted'])->get();
        return view('pages.staff-recipient-verification', compact('requests'));
    }

    public function verificationDetail($type, $reference)
    {
        $record = null;
        if ($type === 'donor') {
            $record = Donation::with('user')->where('reference', $reference)->firstOrFail();
        } else {
            $record = HairRequest::with('user')->where('reference', $reference)->firstOrFail();
        }

        return view('pages.staff-verification-detail', compact('type', 'reference', 'record'));
    }

    public function updateVerificationStatus(Request $request, $type, $reference)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'remarks' => 'required|string',
        ]);

        $record = null;
        if ($type === 'donor') {
            $record = Donation::where('reference', $reference)->firstOrFail();
        } else {
            $record = HairRequest::where('reference', $reference)->firstOrFail();
        }

        $record->update([
            'status' => $validated['status'],
        ]);

        // Save the status change to history
        $record->statusHistories()->create([
            'status' => $validated['status'],
            'notes' => $validated['remarks'],
        ]);

        return response()->json(['message' => 'Status updated successfully', 'success' => true]);
    }

    public function realtimeTracking()
    {
        $donations = Donation::with('user')
            ->whereIn('status', ['Received', 'In Queue', 'In Progress', 'Completed'])
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('pages.staff-realtime-tracking', compact('donations'));
    }

    public function deliveryBatches()
    {
        $batches = WigProduction::with(['wigmaker', 'donation'])
            ->whereIn('status', ['completed', 'processing'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy(function ($task) {
                // Group by wigmaker and month for batch grouping
                return $task->wigmaker_id . '-' . $task->created_at->format('Y-m');
            })
            ->map(function ($group, $key) {
                static $batchNum = 0;
                $batchNum++;
                return (object) [
                    'batch_number' => $batchNum,
                    'date' => $group->first()->updated_at,
                    'count' => $group->count(),
                    'status' => $group->every(fn($t) => $t->status === 'completed') ? 'Completed' : 'In Process',
                ];
            })
            ->values();

        return view('pages.staff-delivery-batches', compact('batches'));
    }

    public function hairStock()
    {
        $donations = Donation::where('status', 'Completed')->get();
        
        $stock = [
            'Short' => ['Black' => 0, 'Brown' => 0, 'Light' => 0],
            'Medium' => ['Black' => 0, 'Brown' => 0, 'Light' => 0],
            'Long' => ['Black' => 0, 'Brown' => 0, 'Light' => 0],
        ];

        foreach ($donations as $donation) {
            $len = ucfirst(strtolower($donation->hair_length));
            $col = ucfirst(strtolower($donation->hair_color));
            
            if (isset($stock[$len])) {
                // Map color aliases if needed
                if (str_contains($col, 'Black')) $col = 'Black';
                if (str_contains($col, 'Brown')) $col = 'Brown';
                if (str_contains($col, 'Light') || str_contains($col, 'Blonde')) $col = 'Light';

                if (isset($stock[$len][$col])) {
                    $stock[$len][$col]++;
                }
            }
        }

        return view('pages.staff-hair-stock', compact('stock'));
    }

    public function wigStock()
    {
        $wigs = WigProduction::with('donation')
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('pages.staff-wig-stock', compact('wigs'));
    }

    public function recipientMatchingList()
    {
        $requests = HairRequest::with('user')
            ->whereIn('status', ['Validated', 'Matched', 'In Transit', 'Arrived'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Get completed wigs to find assigned wig codes
        $wigs = WigProduction::where('status', 'completed')->get()->keyBy('id');

        return view('pages.staff-recipient-matching-list', compact('requests', 'wigs'));
    }

    public function ruleMatching()
    {
        $recipients = HairRequest::with('user')
            ->whereIn('status', ['Validated', 'Submitted'])
            ->get();
        
        $wigs = WigProduction::with('donation')
            ->where('status', 'completed')
            ->get();

        return view('pages.staff-rule-matching', compact('recipients', 'wigs'));
    }
}

