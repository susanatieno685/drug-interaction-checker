@extends('layouts.admin')

@section('title', 'Drugs - Admin - ' . config('app.name', 'Drug Interaction Checker'))

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Drugs</h1>
            <p class="text-secondary mb-0">Manage the medicines available in the database.</p>
        </div>
        <a href="{{ route('admin.drugs.create') }}" class="btn btn-primary">
            Add Drug
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.drugs.index') }}" class="row g-3 align-items-end">
                <div class="col-12 col-md-8 col-lg-6">
                    <label for="search" class="form-label fw-semibold">Search drugs</label>
                    <input
                        type="search"
                        id="search"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Search by generic or brand name"
                    >
                </div>
                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                    @if ($search !== '')
                        <a href="{{ route('admin.drugs.index') }}" class="btn btn-link">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($drugs->isEmpty())
                <p class="text-secondary mb-0">No drugs found.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Generic name</th>
                                <th scope="col">Brand name</th>
                                <th scope="col">Class</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drugs as $drug)
                                <tr>
                                    <td class="fw-semibold">{{ $drug->generic_name }}</td>
                                    <td>{{ $drug->brand_name ?? '—' }}</td>
                                    <td>{{ $drug->drug_class ?? '—' }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ $drug->is_active ? 'success' : 'secondary' }}">
                                            {{ $drug->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Drug actions">
                                            <a href="{{ route('admin.drugs.edit', $drug) }}" class="btn btn-outline-primary">Edit</a>
                                            <form
                                                method="POST"
                                                action="{{ route('admin.drugs.destroy', $drug) }}"
                                                onsubmit="return confirm('Delete this drug? If it is used in an interaction, deletion will be blocked.');"
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
                    {{ $drugs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
