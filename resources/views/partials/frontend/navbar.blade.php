<nav class="navbar navbar-expand-lg navbar-dark frontend-navbar sticky-top">
    <div class="container py-2">
        <a class="navbar-brand mb-0 text-white" href="{{ url('/') }}">
            @include('partials.branding.logo')
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#frontendNav" aria-controls="frontendNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="frontendNav">
            <div class="ms-auto d-flex flex-column flex-lg-row align-items-lg-center gap-2 pt-3 pt-lg-0">
                <a
                    class="btn btn-sm nav-pill {{ request()->routeIs('home') ? 'nav-pill-active' : 'nav-pill-ghost' }}"
                    href="{{ url('/') }}"
                >
                    Home
                </a>
                @auth
                    <a
                        class="btn btn-sm nav-pill {{ request()->routeIs('dashboard') ? 'nav-pill-active' : 'nav-pill-ghost' }}"
                        href="{{ route('dashboard') }}"
                    >
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm nav-pill nav-pill-logout">Logout</button>
                    </form>
                @else
                    <a
                        class="btn btn-sm nav-pill nav-pill-ghost {{ request()->routeIs('login') ? 'nav-pill-active' : '' }}"
                        href="{{ route('login') }}"
                    >
                        Login
                    </a>
                    <a
                        class="btn btn-sm nav-pill nav-pill-register {{ request()->routeIs('register') ? 'nav-pill-active' : '' }}"
                        href="{{ route('register') }}"
                    >
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
