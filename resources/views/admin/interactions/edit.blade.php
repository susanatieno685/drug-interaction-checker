@extends('layouts.admin')

@section('title', 'Edit Interaction - Admin - ' . config('app.name', 'Drug Interaction Checker'))

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Edit interaction</h1>
        <p class="text-secondary mb-0">Update the clinical details for this drug pair.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.interactions.update', $interaction) }}">
                @csrf
                @method('PUT')
                @include('admin.interactions.partials.form', [
                    'interaction' => $interaction,
                    'drugs' => $drugs,
                    'severities' => $severities,
                ])

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Update Interaction</button>
                    <a href="{{ route('admin.interactions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
