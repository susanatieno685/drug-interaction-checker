@extends('layouts.frontend')

@section('title', config('app.name', 'Drug Interaction Checker'))

@section('content')
    <div class="row justify-content-center align-items-center g-4">
        <div class="col-12 col-xl-5">
            <div class="pe-xl-4">
                <span class="badge text-bg-primary rounded-pill mb-3">Version 1 public checker</span>
                <h1 class="display-5 fw-bold mb-3">Drug Interaction Checker</h1>
                <p class="lead text-secondary mb-4">
                    Search two medicines, review the interaction result, and keep clinical decisions grounded in the current database.
                </p>
                <div class="alert alert-warning border-0 shadow-sm mb-0" role="alert">
                    Clinical content in this application must be reviewed by a pharmacist before use in patient care.
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" id="checker">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4">
                        <h2 class="h4 fw-bold mb-2">Check an interaction</h2>
                        <p class="text-secondary mb-0">Choose two different drugs to begin the lookup.</p>
                    </div>

                    @if ($drugs->isEmpty())
                        <div class="alert alert-info border-0 shadow-sm mb-0" role="alert">
                            No drugs are available in the current database yet. Please ask an administrator to load seed data.
                        </div>
                    @else
                        <form method="POST" action="{{ route('interaction.check') }}" class="row g-3" data-interaction-form>
                        @csrf
                        <div class="col-12 col-md-6">
                            <label for="drug-a-search" class="form-label fw-semibold">Drug A</label>
                            <input
                                id="drug-a-search"
                                type="search"
                                class="form-control form-control-lg mb-2"
                                placeholder="Search drug A"
                                autocomplete="off"
                                data-select-search="drug-a"
                                aria-describedby="drug-a-help"
                            >
                            <select id="drug-a" name="drug_a_id" class="form-select form-select-lg" aria-describedby="drug-a-help" size="6">
                                <option value="">Choose a drug</option>
                                @foreach ($drugs as $drug)
                                    <option value="{{ $drug->id }}" @selected(old('drug_a_id') == $drug->id)>
                                        {{ $drug->generic_name }}{{ $drug->brand_name ? ' (' . $drug->brand_name . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="drug-a-help" class="form-text">Select the first medicine.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="drug-b-search" class="form-label fw-semibold">Drug B</label>
                            <input
                                id="drug-b-search"
                                type="search"
                                class="form-control form-control-lg mb-2"
                                placeholder="Search drug B"
                                autocomplete="off"
                                data-select-search="drug-b"
                                aria-describedby="drug-b-help"
                            >
                            <select id="drug-b" name="drug_b_id" class="form-select form-select-lg" aria-describedby="drug-b-help" size="6">
                                <option value="">Choose a drug</option>
                                @foreach ($drugs as $drug)
                                    <option value="{{ $drug->id }}" @selected(old('drug_b_id') == $drug->id)>
                                        {{ $drug->generic_name }}{{ $drug->brand_name ? ' (' . $drug->brand_name . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="drug-b-help" class="form-text">Select the second medicine.</div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg px-4" data-submit-button>
                                <span class="button-text">Check Interaction</span>
                                <span class="button-loading d-none" aria-hidden="true">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Checking...
                                </span>
                            </button>
                        </div>
                        </form>
                    @endif

                    <div class="mt-4 pt-3 border-top">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <h3 class="h6 fw-bold">Two-drug lookup</h3>
                                    <p class="small text-secondary mb-0">
                                        Version 1 focuses on checking one drug pair at a time.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <h3 class="h6 fw-bold">Responsive by default</h3>
                                    <p class="small text-secondary mb-0">
                                        The layout uses Bootstrap 5 and adapts cleanly to smaller screens.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
