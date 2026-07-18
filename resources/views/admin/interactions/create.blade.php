@extends('layouts.admin')

@section('title', 'Add Interaction - Admin - ' . config('app.name', 'Drug Interaction Checker'))

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Add interaction</h1>
        <p class="text-secondary mb-0">Create a new drug interaction record.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.interactions.store') }}">
                @csrf
                @include('admin.interactions.partials.form', [
                    'interaction' => null,
                    'drugs' => $drugs,
                    'severities' => $severities,
                ])

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Save Interaction</button>
                    <a href="{{ route('admin.interactions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
