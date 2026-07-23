@extends('layouts.frontend')

@section('title', 'Home | ' . config('app.name', 'DawaCross'))

@section('content')
    <div class="row align-items-center g-4 g-lg-5">
        <div class="col-12 col-xl-6">
            <div class="hero-panel rounded-4 p-4 p-md-5">
                <span class="badge rounded-pill text-bg-primary mb-3 px-3 py-2">Clinical decision support</span>
                <h1 class="display-5 fw-bold mb-3">Check Drug Interactions with Confidence</h1>
                <p class="lead text-muted mb-4">
                    Evidence-based drug interaction checking designed for healthcare professionals and students.
                </p>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="#checker" class="btn btn-primary btn-lg px-4">Check Interactions</a>
                    <a href="#learn-more" class="btn btn-outline-primary btn-lg px-4">Learn More</a>
                </div>
                <div class="row g-3" id="learn-more">
                    <div class="col-md-4">
                        <div class="surface-soft rounded-4 p-3 h-100">
                            <h2 class="h6 fw-bold mb-2">Safety</h2>
                            <p class="small text-muted mb-0">Focused on clear interaction risk communication.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="surface-soft rounded-4 p-3 h-100">
                            <h2 class="h6 fw-bold mb-2">Accuracy</h2>
                            <p class="small text-muted mb-0">Matches are based on your current local database.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="surface-soft rounded-4 p-3 h-100">
                            <h2 class="h6 fw-bold mb-2">Simplicity</h2>
                            <p class="small text-muted mb-0">Clean workflows for fast clinical review.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card rounded-4 overflow-hidden" id="checker">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4">
                        <h2 class="h4 fw-bold mb-2">DawaCross</h2>
                        <p class="text-muted mb-0">Choose two different drugs to begin the lookup.</p>
                    </div>

                    @if ($drugs->isEmpty())
                        <div class="alert alert-info mb-0" role="alert">
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
                            <select id="drug-a" name="drug_a_id" class="form-select form-select-lg interaction-select" aria-describedby="drug-a-help" size="6">
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
                            <select id="drug-b" name="drug_b_id" class="form-select form-select-lg interaction-select" aria-describedby="drug-b-help" size="6">
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

                    
                </div>
            </div>
        </div>
    </div>

    @include('partials.faq')
@endsection
