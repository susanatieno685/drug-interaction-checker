<div class="px-3">
    <div class="mb-4">
        <h2 class="h6 text-uppercase text-secondary mb-1">Admin Menu</h2>
        @auth
            @if (auth()->user()?->isAdmin())
                <p class="small text-secondary mb-0">
                    {{ auth()->user()->name }} - {{ ucfirst(auth()->user()->role) }}
                </p>
            @else
                <p class="small text-secondary mb-0">Restricted area.</p>
            @endif
        @endauth
    </div>
    @auth
        @if (auth()->user()?->isAdmin())
            <nav class="nav flex-column gap-1">
                <a class="nav-link px-0 text-dark fw-medium {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link px-0 text-dark fw-medium {{ request()->routeIs('admin.drugs.*') ? 'active' : '' }}" href="{{ route('admin.drugs.index') }}">Drugs</a>
                <a class="nav-link px-0 text-dark fw-medium {{ request()->routeIs('admin.interactions.*') ? 'active' : '' }}" href="{{ route('admin.interactions.index') }}">Interactions</a>
            </nav>
        @endif
    @endauth
</div>
