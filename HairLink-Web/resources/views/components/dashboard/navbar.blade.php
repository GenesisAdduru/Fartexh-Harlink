<header class="dash-header" data-dash-header>
    <nav class="dash-nav" aria-label="Dashboard navigation">
        <a class="dash-brand" href="{{ url('/') }}" aria-label="HairLink home">
            <img src="{{ asset('assets/images/landing/pink-ribbon.png') }}" alt="Pink ribbon icon">
            <span>HairLink</span>
        </a>

        <button class="dash-burger" type="button" aria-label="Toggle menu" data-dash-burger>
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="dash-links" data-dash-links>
            <a href="{{ url('/') }}">Home</a>
            @unless(request()->routeIs('donor.*'))
                <a href="{{ route('dashboard.preview') }}" class="{{ request()->routeIs('dashboard.preview') ? 'active' : '' }}">Dashboards</a>
            @endunless
            <a href="{{ route('donor.dashboard') }}" class="{{ request()->routeIs('donor.dashboard') ? 'active' : '' }}">Overview</a>
            <a href="{{ route('donor.donate') }}" class="{{ request()->routeIs('donor.donate') ? 'active' : '' }}">Donate Hair</a>
            <a href="{{ route('donor.tracking') }}" class="{{ request()->routeIs('donor.tracking*') ? 'active' : '' }}">Tracking</a>
            <a href="{{ route('donor.certificate') }}" class="{{ request()->routeIs('donor.certificate') ? 'active' : '' }}">Certificate</a>
            <a href="{{ route('login') }}">Logout</a>
        </div>
    </nav>
</header>
