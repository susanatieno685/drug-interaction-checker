@extends('layouts.admin')

@section('title', 'Add Drug | ' . config('app.name', 'DawaCross'))

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Add drug</h1>
        <p class="text-secondary mb-0">Create a new medicine record for the database.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.drugs.store') }}">
                @csrf
                @include('admin.drugs.partials.form', ['drug' => null])

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Save Drug</button>
                    <a href="{{ route('admin.drugs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
