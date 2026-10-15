@extends('layouts.frontend')

@section('title', 'Verify email | ' . config('app.name', 'DawaCross'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-7">
            <div class="card rounded-4 surface-soft">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 fw-bold mb-3">Verify your email address</h1>
                    <p class="text-muted">We sent a secure verification link to your email address. Open the link to continue to your dashboard.</p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success" role="status">A new verification link has been sent to your email address.</div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Resend verification email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
