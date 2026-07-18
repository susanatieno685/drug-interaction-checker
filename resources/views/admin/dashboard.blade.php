@extends('layouts.admin')

@section('title', 'Admin Dashboard - ' . config('app.name', 'Drug Interaction Checker'))

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Admin dashboard</h1>
        <p class="text-secondary mb-0">Overview of the current database content.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total drugs</p>
                    <div class="display-6 fw-bold">{{ $totalDrugs }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total interactions</p>
                    <div class="display-6 fw-bold">{{ $totalInteractions }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Active interactions</p>
                    <div class="display-6 fw-bold">{{ $activeInteractions }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total users</p>
                    <div class="display-6 fw-bold">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h2 class="h5 fw-bold mb-0">Recent interactions</h2>
        </div>
        <div class="card-body">
            @if ($recentInteractions->isEmpty())
                <p class="text-secondary mb-0">No interactions have been added yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Drug pair</th>
                                <th>Severity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentInteractions as $interaction)
                                <tr>
                                    <td>{{ $interaction->drugA->generic_name }} + {{ $interaction->drugB->generic_name }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ $interaction->severity->bootstrap_class }}">
                                            {{ $interaction->severity->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-{{ $interaction->is_active ? 'success' : 'secondary' }}">
                                            {{ $interaction->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
