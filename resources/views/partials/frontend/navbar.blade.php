<nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container py-2 d-flex flex-column flex-md-row align-items-md-center gap-2 gap-md-4">
        <a class="navbar-brand fw-semibold mb-0" href="{{ url('/') }}">
            {{ config('app.name', 'Drug Interaction Checker') }}
        </a>

        <div class="ms-md-auto d-flex flex-wrap align-items-center gap-2">
            <a
                class="btn btn-sm nav-pill {{ request()->routeIs('home') ? 'nav-pill-active' : 'btn-outline-light' }}"
                href="{{ url('/') }}"
            >
                Home
            </a>
            @auth
                <a
                    class="btn btn-sm nav-pill {{ request()->routeIs('dashboard') ? 'nav-pill-active' : 'btn-outline-light' }}"
                    href="{{ route('dashboard') }}"
                >
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light nav-pill nav-pill-logout">Logout</button>
                </form>
            @else
                <a
                    class="btn btn-sm nav-pill {{ request()->routeIs('login') ? 'nav-pill-active' : 'btn-outline-light' }}"
                    href="{{ route('login') }}"
                >
                    Login
                </a>
                <a
                    class="btn btn-sm nav-pill {{ request()->routeIs('register') ? 'nav-pill-active' : 'btn-light' }}"
                    href="{{ route('register') }}"
                >
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>
