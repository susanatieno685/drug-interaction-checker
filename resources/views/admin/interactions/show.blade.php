@extends('layouts.admin')

@section('title', 'Interaction Details | ' . config('app.name', 'DawaCross'))

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Interaction details</h1>
            <p class="text-secondary mb-0">{{ $interaction->drugA->generic_name }} + {{ $interaction->drugB->generic_name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.interactions.edit', $interaction) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.interactions.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="badge text-bg-{{ $interaction->severity->bootstrap_class }} fs-6 px-3 py-2">
                    {{ $interaction->severity->name }}
                </span>
                <span class="badge text-bg-{{ $interaction->is_active ? 'success' : 'secondary' }}">
                    {{ $interaction->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <div class="p-3 border rounded-3 bg-light">
                        <h2 class="h6 fw-bold">Clinical effect</h2>
                        <p class="mb-0">{{ $interaction->clinical_effect }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <h2 class="h6 fw-bold">Mechanism</h2>
                        <p class="mb-0">{{ $interaction->mechanism }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <h2 class="h6 fw-bold">Management</h2>
                        <p class="mb-0">{{ $interaction->management }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <h2 class="h6 fw-bold">Monitoring advice</h2>
                        <p class="mb-0">{{ $interaction->monitoring_advice ?? '—' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <h2 class="h6 fw-bold">Evidence level</h2>
                        <p class="mb-0">{{ $interaction->evidence_level ?? '—' }}</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 border rounded-3 bg-light">
                        <h2 class="h6 fw-bold">Reference</h2>
                        <p class="mb-0">{{ $interaction->reference ?? '—' }}</p>
                    </div>
                </div>
                @if ($interaction->notes)
                    <div class="col-12">
                        <div class="p-3 border rounded-3 bg-light">
                            <h2 class="h6 fw-bold">Notes</h2>
                            <p class="mb-0">{{ $interaction->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
