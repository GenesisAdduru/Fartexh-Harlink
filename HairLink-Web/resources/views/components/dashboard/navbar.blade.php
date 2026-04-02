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

        <div class="dash-links" data-dash-links>
            <a href="{{ Auth::user()->role === 'recipient' ? route('recipient.dashboard') : route('donor.dashboard') }}">Home</a>
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
            @else
                <a href="{{ route('donor.dashboard') }}">Donate Hair</a>
                <a href="{{ route('recipient.dashboard') }}">Request Hair</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>
</header>
