<header class="dash-header" data-dash-header>
    <nav class="dash-nav" aria-label="Dashboard navigation">
        <a class="dash-brand" href="{{ Auth::user()->role === 'recipient' ? route('recipient.dashboard') : route('donor.dashboard') }}" aria-label="HairLink home">
            <img src="{{ asset('assets/images/landing/pink-ribbon.png') }}" alt="Pink ribbon icon">
            <span>HairLink</span>
        </a>

        <button class="dash-burger" type="button" aria-label="Toggle menu" data-dash-burger>
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="dash-links {{ request()->routeIs('staff.*') ? 'dash-links-staff' : '' }} {{ request()->routeIs('admin.*') ? 'dash-links-staff' : '' }}" data-dash-links>
            <a href="{{ url('/') }}">Home</a>
            @if(request()->routeIs('donor.*'))
                <a href="{{ route('donor.dashboard') }}" class="{{ request()->routeIs('donor.dashboard') ? 'active' : '' }}">Overview</a>
                <a href="{{ route('donor.donate') }}" class="{{ request()->routeIs('donor.donate') ? 'active' : '' }}">Donate Hair</a>
                <a href="{{ route('donor.tracking') }}" class="{{ request()->routeIs('donor.tracking*') ? 'active' : '' }}">Tracking</a>
                <a href="{{ route('donor.certificate') }}" class="{{ request()->routeIs('donor.certificate') ? 'active' : '' }}">Certificate</a>
                <a href="{{ route('donor.profile') }}" class="{{ request()->routeIs('donor.profile') ? 'active' : '' }}">Profile</a>
            @elseif(request()->routeIs('recipient.*'))
                <a href="{{ route('recipient.dashboard') }}" class="{{ request()->routeIs('recipient.dashboard') ? 'active' : '' }}">Overview</a>
                <a href="{{ route('recipient.request') }}" class="{{ request()->routeIs('recipient.request') ? 'active' : '' }}">Request Hair</a>
                <a href="{{ route('recipient.tracking') }}" class="{{ request()->routeIs('recipient.tracking*') ? 'active' : '' }}">Tracking</a>
                <a href="{{ route('recipient.profile') }}" class="{{ request()->routeIs('recipient.profile') ? 'active' : '' }}">Profile</a>
            @elseif(request()->routeIs('wigmaker.*'))
                <a href="{{ route('wigmaker.dashboard') }}" class="{{ request()->routeIs('wigmaker.dashboard') ? 'active' : '' }}">Overview</a>
                <a href="{{ route('wigmaker.dashboard') }}#tasksBoard" class="{{ request()->routeIs('wigmaker.task.*') ? 'active' : '' }}">Production Tasks</a>
            @elseif(request()->routeIs('staff.*'))
                <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">Overview</a>
                <a href="{{ route('staff.donor-verification') }}" class="{{ request()->routeIs('staff.donor-verification') ? 'active' : '' }}">Donor</a>
                <a href="{{ route('staff.recipient-verification') }}" class="{{ request()->routeIs('staff.recipient-verification') ? 'active' : '' }}">Recipient</a>
                <a href="{{ route('staff.realtime-tracking') }}" class="{{ request()->routeIs('staff.realtime-tracking') ? 'active' : '' }}">Tracking</a>
                <a href="{{ route('staff.wig-stock') }}" class="{{ request()->routeIs('staff.hair-stock') || request()->routeIs('staff.wig-stock') ? 'active' : '' }}">Stock</a>
                <a href="{{ route('staff.rule-matching') }}" class="{{ request()->routeIs('staff.rule-matching') || request()->routeIs('staff.recipient-matching-list') ? 'active' : '' }}">Matching</a>
            @elseif(request()->routeIs('admin.*'))
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Overview</a>
                <a href="{{ route('admin.verification') }}" class="{{ request()->routeIs('admin.verification') ? 'active' : '' }}">Verify</a>
                <a href="{{ route('admin.matching') }}" class="{{ request()->routeIs('admin.matching') ? 'active' : '' }}">Matching</a>
                <a href="{{ route('admin.operations') }}" class="{{ request()->routeIs('admin.operations') ? 'active' : '' }}">Ops</a>
                <a href="{{ route('admin.inventory') }}" class="{{ request()->routeIs('admin.inventory') ? 'active' : '' }}">Inventory</a>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Users</a>
                <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">Reports</a>
            @else
                <a href="{{ route('donor.dashboard') }}">Donate Hair</a>
                <a href="{{ route('recipient.dashboard') }}">Request Hair</a>
                <a href="{{ route('wigmaker.dashboard') }}">Wigmaker</a>
                <a href="{{ route('staff.dashboard') }}">Staff</a>
            @endif
            <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>
</header>
