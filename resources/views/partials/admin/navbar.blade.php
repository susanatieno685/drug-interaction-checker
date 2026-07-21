<nav class="navbar navbar-expand-lg navbar-dark frontend-navbar border-bottom">
    <div class="container-fluid px-3">
        <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}">
            @include('partials.branding.logo')
        </a>

        @auth
            @if (auth()->user()?->isAdmin())
                <div class="d-flex align-items-center gap-2 small ms-auto text-white">
                    <span class="fw-semibold">{{ auth()->user()->name }}</span>
                    <span class="badge text-bg-light text-uppercase text-primary">Admin</span>
                </div>
            @endif
        @endauth
    </div>
</nav>
