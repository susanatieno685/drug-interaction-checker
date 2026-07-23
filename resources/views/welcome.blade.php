<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DawaCross') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="frontend-shell">
    <header class="frontend-navbar sticky-top">
        <div class="container py-2">
            <a class="navbar-brand mb-0 text-white text-decoration-none" href="{{ url('/') }}">
                @include('partials.branding.logo')
            </a>
            <div class="d-none d-md-flex gap-2 ms-auto">
                @auth
                    <a class="btn btn-sm nav-pill nav-pill-ghost" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a class="btn btn-sm nav-pill nav-pill-ghost" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-sm nav-pill nav-pill-register" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="py-4 py-lg-5">
        <div class="container">
            <section class="hero-panel rounded-4 p-4 p-md-5 mb-4 mb-lg-5">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-lg-7">
                        <span class="badge rounded-pill text-bg-primary mb-3 px-3 py-2">Drug Interaction Checker</span>
                        <h1 class="display-5 fw-bold mb-3">Check medication combinations with a clearer, faster workflow.</h1>
                        <p class="lead text-muted mb-4">
                            Compare two drugs, review severity, and support safer clinical decisions with a Bootstrap-powered interface.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">Get Started</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">Create Account</a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="card rounded-4 surface-soft border-0">
                            <div class="card-body p-4">
                                <h2 class="h5 fw-bold mb-3">What you can do</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        Search interactions
                                        <span class="badge text-bg-light text-primary">Fast</span>
                                    </li>
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        Review severity levels
                                        <span class="badge text-bg-light text-primary">Clear</span>
                                    </li>
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        Use on mobile or desktop
                                        <span class="badge text-bg-light text-primary">Responsive</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @include('partials.frontend.footer')
        </div>
    </main>
</body>
</html>
