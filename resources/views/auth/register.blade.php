@extends('layouts.frontend')

@section('title', 'Register | ' . config('app.name', 'DawaCross'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card rounded-4 surface-soft">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 fw-bold mb-3">Create account</h1>
                    <p class="text-muted mb-4">Register to access protected pages.</p>

                    <form method="POST" action="{{ route('register.store') }}" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="password_confirmation" class="form-label">Confirm password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
