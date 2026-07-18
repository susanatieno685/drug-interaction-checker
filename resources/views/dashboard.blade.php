@extends('layouts.frontend')

@section('title', 'Dashboard - ' . config('app.name', 'Drug Interaction Checker'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 fw-bold mb-3">Dashboard</h1>
                    <p class="text-secondary mb-4">You are signed in.</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
