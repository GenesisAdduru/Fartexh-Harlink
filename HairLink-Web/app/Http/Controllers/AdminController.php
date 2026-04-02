<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use App\Models\HairRequest;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $donationsCount = Donation::count();
        $requestsCount = HairRequest::count();
        $pendingVerifications = Donation::where('status', 'Received')->count() + HairRequest::where('status', 'Submitted')->count();

        // Sample static data for what might be complex queries
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $recentDonations = Donation::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        return view('pages.admin-dashboard', compact('usersCount', 'donationsCount', 'requestsCount', 'pendingVerifications', 'recentUsers', 'recentDonations'));
    }

    public function verification()
    {
        $pendingDonations = Donation::with('user')->where('status', 'Received')->get();
        $pendingRequests = HairRequest::with('user')->where('status', 'Submitted')->get();

        return view('pages.admin-verification', compact('pendingDonations', 'pendingRequests'));
    }

    public function matching()
    {
        // Fetch logic for matching
        $availableDonations = Donation::with('user')->where('status', 'Completed')->get();
        $approvedRequests = HairRequest::with('user')->where('status', 'Validated')->get();

        return view('pages.admin-matching', compact('availableDonations', 'approvedRequests'));
    }

    public function operations()
    {
        // Active wig makers and shipping statuses
        return view('pages.admin-operations');
    }

    public function inventory()
    {
        // Real inventory counts based on donations
        $donationsCount = Donation::where('status', 'Completed')->count();
        
        return view('pages.admin-inventory', compact('donationsCount'));
    }

    public function users()
    {
        $users = User::paginate(10);
        $donorCount = User::where('role', 'donor')->count();
        $recipientCount = User::where('role', 'recipient')->count();
        $staffCount = User::where('role', 'staff')->count();
        $wigmakerCount = User::where('role', 'wigmaker')->count();

        return view('pages.admin-users', compact('users', 'donorCount', 'recipientCount', 'staffCount', 'wigmakerCount'));
    }

    public function events()
    {
        return view('pages.admin-events');
    }

    public function community()
    {
        return view('pages.admin-community');
    }

    public function reports()
    {
        $donationsCount = Donation::count();
        $requestsCount = HairRequest::count();
        
        return view('pages.admin-reports', compact('donationsCount', 'requestsCount'));
    }
}
