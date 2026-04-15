<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HairRequest;
use Illuminate\Support\Facades\Auth;

class RecipientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user) return redirect('/login');

        $requests = HairRequest::with(['statusHistories', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.recipient-dashboard', compact('requests'));
    }

    public function tracking()
    {
        $user = Auth::user();
        if (!$user) return redirect('/login');

        $requests = HairRequest::with(['statusHistories', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.recipient-tracking', compact('requests'));
    }

    public function trackingDetail($reference)
    {
        $user = Auth::user();
        if (!$user) return redirect('/login');

        $requestData = HairRequest::with(['statusHistories', 'user'])
            ->where('reference', $reference)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('pages.recipient-tracking-detail', compact('requestData'));
    }
}
