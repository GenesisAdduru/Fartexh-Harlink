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
            $record = HairRequest::with('user')->where('reference_number', $reference)->firstOrFail();
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
            $record = HairRequest::where('reference_number', $reference)->firstOrFail();
        }

        $record->update([
            'status' => $validated['status'],
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
        return view('pages.staff-delivery-batches');
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
        return view('pages.staff-recipient-matching-list');
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
