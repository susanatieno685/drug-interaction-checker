<nav class="navbar navbar-dark bg-dark border-bottom border-dark-subtle">
    <div class="container-fluid px-3">
        <a class="navbar-brand fw-semibold" href="{{ route('admin.dashboard') }}">{{ config('app.name', 'Drug Interaction Checker') }} Admin</a>

        @auth
            @if (auth()->user()?->isAdmin())
                <div class="d-flex align-items-center gap-2 text-white small">
                    <span class="fw-semibold">{{ auth()->user()->name }}</span>
                    <span class="badge text-bg-light text-dark text-uppercase">Admin</span>
                </div>
            @endif
        @endauth
    </div>
</nav>
