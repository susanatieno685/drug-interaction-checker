@extends('layouts.admin')

@section('title', 'Edit Drug - Admin - ' . config('app.name', 'Drug Interaction Checker'))

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Edit drug</h1>
        <p class="text-secondary mb-0">Update the medicine details below.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.drugs.update', $drug) }}">
                @csrf
                @method('PUT')
                @include('admin.drugs.partials.form', ['drug' => $drug])

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Update Drug</button>
                    <a href="{{ route('admin.drugs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
