<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\HairRequest;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user) return redirect('/login');

        // Fetch hair donations first
        $donations = Donation::with('statusHistories')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Points: 1 star for every ₱100 donated monetary
        $monetaryDonations = \App\Models\MonetaryDonation::where('user_id', $user->id)
            ->where('status', 'Completed')
            ->sum('amount');
        
        $monetaryPoints = floor($monetaryDonations / 100);
        $hairPoints = $donations->count() * 10;
        
        $points = $monetaryPoints + $hairPoints;

        return view('pages.donor-dashboard', compact('donations', 'points'));
    }

    public function tracking()
    {
        $user = Auth::user();
        if (!$user) return redirect('/login');

        $donations = Donation::with('statusHistories')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('pages.donor-tracking', compact('donations'));
    }

    public function trackingDetail($reference)
    {
        $user = Auth::user();
        $donation = Donation::with('statusHistories')->where('reference', $reference)->where('user_id', $user->id)->firstOrFail();
        
        return view('pages.donor-tracking-detail', compact('donation'));
    }

    public function certificate(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect('/login');

        $ref = $request->query('ref');
        
        $query = Donation::where('user_id', $user->id)
                         ->whereIn('status', ['Verified', 'Completed']);

        if ($ref) {
            $donation = $query->where('reference', $ref)->first();
        } else {
            $donation = $query->orderBy('created_at', 'desc')->first();
        }
                             
        return view('pages.donor-certificate', compact('donation'));
    }
}
