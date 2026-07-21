@extends('layouts.admin')

@section('title', 'Interactions | ' . config('app.name', 'DawaCross'))

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Interactions</h1>
        <p class="text-muted mb-0">Manage the clinical interaction records in the database.</p>
        </div>
        <a href="{{ route('admin.interactions.create') }}" class="btn btn-primary">
            Add Interaction
        </a>
    </div>

    <div class="card surface-soft mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.interactions.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-md-6">
                    <label for="search" class="form-label fw-semibold">Search drug name</label>
                    <input
                        type="search"
                        id="search"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Search by generic or brand name"
                    >
                </div>
                <div class="col-12 col-md-4">
                    <label for="severity_id" class="form-label fw-semibold">Filter by severity</label>
                    <select id="severity_id" name="severity_id" class="form-select">
                        <option value="">All severities</option>
                        @foreach ($severities as $severity)
                            <option value="{{ $severity->id }}" @selected((string) $severityId === (string) $severity->id)>
                                {{ $severity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                    @if ($search !== '' || filled($severityId))
                        <a href="{{ route('admin.interactions.index') }}" class="btn btn-link">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card surface-soft">
        <div class="card-body">
            @if ($interactions->isEmpty())
                <p class="text-muted mb-0">No interactions found.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Drug pair</th>
                                <th scope="col">Severity</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($interactions as $interaction)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $interaction->drugA->generic_name }} + {{ $interaction->drugB->generic_name }}
                                    </td>
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
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Interaction actions">
                                            <a href="{{ route('admin.interactions.show', $interaction) }}" class="btn btn-outline-secondary">Show</a>
                                            <a href="{{ route('admin.interactions.edit', $interaction) }}" class="btn btn-outline-primary">Edit</a>
                                            <form
                                                method="POST"
                                                action="{{ route('admin.interactions.destroy', $interaction) }}"
                                                onsubmit="return confirm('Delete this interaction?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $interactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
