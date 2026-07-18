@extends('layouts.frontend')

@section('title', 'Interaction Result - ' . config('app.name', 'Drug Interaction Checker'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <span class="badge text-bg-primary rounded-pill mb-2">Interaction result</span>
                    <h1 class="h3 fw-bold mb-0">Drug interaction details</h1>
                </div>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    Check another pair
                </a>
            </div>

            @if (!empty($message))
                <div class="card border-0 shadow-sm rounded-4 mb-4" aria-live="polite">
                    <div class="card-body p-4 p-md-5">
                        <div class="alert alert-info border-0 mb-3" role="alert">
                            {{ $message }}
                        </div>
                        <p class="mb-0 text-secondary">
                            You can check a different pair of medicines using the button below. This result only reflects the current application database.
                        </p>
                    </div>
                </div>
            @endif

            @if (!empty($interaction))
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
                            <div>
                                <p class="text-secondary mb-1">
                                    {{ $interaction->drugA->generic_name }} + {{ $interaction->drugB->generic_name }}
                                </p>
                                <h2 class="h4 fw-bold mb-0">Current database match</h2>
                            </div>
                            <span class="badge text-bg-{{ $interaction->severity->bootstrap_class }} fs-6 px-3 py-2">
                                {{ $interaction->severity->name }}
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="p-3 border rounded-3 bg-light">
                                    <h3 class="h6 fw-bold">Clinical effect</h3>
                                    <p class="mb-0">{{ $interaction->clinical_effect }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 h-100 bg-light">
                                    <h3 class="h6 fw-bold">Mechanism</h3>
                                    <p class="mb-0">{{ $interaction->mechanism }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 h-100 bg-light">
                                    <h3 class="h6 fw-bold">Management recommendation</h3>
                                    <p class="mb-0">{{ $interaction->management }}</p>
                                </div>
                            </div>
                            @if ($interaction->monitoring_advice)
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 h-100 bg-light">
                                        <h3 class="h6 fw-bold">Monitoring advice</h3>
                                        <p class="mb-0">{{ $interaction->monitoring_advice }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($interaction->evidence_level)
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 h-100 bg-light">
                                        <h3 class="h6 fw-bold">Evidence level</h3>
                                        <p class="mb-0">{{ $interaction->evidence_level }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($interaction->reference)
                                <div class="col-12">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <h3 class="h6 fw-bold">Reference</h3>
                                        <p class="mb-0">{{ $interaction->reference }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($interaction->notes)
                                <div class="col-12">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <h3 class="h6 fw-bold">Notes</h3>
                                        <p class="mb-0">{{ $interaction->notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="alert alert-warning mt-4 mb-0" role="alert">
                            Clinical content in this application must be reviewed by a pharmacist before use in patient care.
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-lg rounded-4" aria-live="polite">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-3">
                            <span class="badge text-bg-secondary rounded-pill">No database match</span>
                        </div>
                        <h2 class="h4 fw-bold mb-3">No interaction record was found</h2>
                        <p class="text-secondary mb-3">
                            {{ $message }}
                        </p>
                        <div class="alert alert-warning border-0 mb-4" role="alert">
                            This does not mean the combination is medically safe. It means the current database does not contain a matching record.
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                Check another pair
                            </a>
                            <a href="{{ route('home') }}#checker" class="btn btn-outline-secondary">
                                Return to checker
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
