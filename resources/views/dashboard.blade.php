@extends('layouts.frontend')

@section('title', 'Dashboard | ' . config('app.name', 'DawaCross'))

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="dashboard-hero rounded-4 p-4 p-md-5">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                    <div>
                        <h1 class="display-6 fw-bold mb-2">Welcome back, {{ $user?->name ?? 'Clinician' }}.</h1>
                        <p class="lead text-muted mb-0">
                            Review interaction findings, revisit recent checks, and keep an eye on severe combinations.
                        </p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#checker" class="btn btn-primary btn-lg px-4">Check an Interaction</a>
                        <a href="#recent-checks" class="btn btn-outline-primary btn-lg px-4">View History</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card rounded-4 surface-soft border-0">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        @foreach ($navigationItems as $item)
                            @if ($item['label'] === 'Log Out')
                                <form method="POST" action="{{ $item['href'] }}" class="ms-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3">Log Out</button>
                                </form>
                            @else
                                <a href="{{ $item['href'] }}" class="btn btn-sm {{ $loop->first ? 'btn-primary' : 'btn-outline-primary' }} px-3">
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="card metric-card rounded-4 border-0 h-100">
                        <div class="card-body p-4">
                            <span class="metric-label">Total checks</span>
                            <div class="metric-value">{{ number_format($totalChecks) }}</div>
                            <p class="text-muted mb-0">Total interaction records in the current database.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card metric-card rounded-4 border-0 h-100">
                        <div class="card-body p-4">
                            <span class="metric-label">Saved interactions</span>
                            <div class="metric-value">{{ number_format($savedInteractionsCount) }}</div>
                            <p class="text-muted mb-0">Bookmark storage is not yet implemented, so this remains placeholder data.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card metric-card rounded-4 border-0 h-100">
                        <div class="card-body p-4">
                            <span class="metric-label">Major interactions</span>
                            <div class="metric-value">{{ number_format($majorInteractionsCount) }}</div>
                            <p class="text-muted mb-0">Severe or contraindicated entries found in the current library.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8" id="checker">
            <div class="card rounded-4 surface-soft border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
                        <div>
                            <h2 class="h3 fw-bold mb-2">Check an Interaction</h2>
                            <p class="text-muted mb-0">Use the searchable fields to look up medicine or food combinations.</p>
                        </div>
                        <span class="badge text-bg-light text-primary align-self-start">Bootstrap only</span>
                    </div>

                    @if ($drugs->isEmpty())
                        <div class="alert alert-info mb-0" role="alert">
                            No medicines are available in the current database yet. Ask an administrator to load seed data.
                        </div>
                    @else
                        <form method="POST" action="{{ route('interaction.check') }}" class="row g-3" data-interaction-form>
                            @csrf
                            <div class="col-12 col-lg-6">
                                <label for="dashboard-drug-a-search" class="form-label fw-semibold">Medicine / food A</label>
                                <input
                                    id="dashboard-drug-a-search"
                                    type="search"
                                    class="form-control form-control-lg mb-2"
                                    placeholder="Search item A"
                                    autocomplete="off"
                                    data-select-search="dashboard-drug-a"
                                >
                                <select id="dashboard-drug-a" name="drug_a_id" class="form-select form-select-lg interaction-select" size="6" aria-label="Select first item">
                                    <option value="">Choose an item</option>
                                    @foreach ($drugs as $drug)
                                        <option value="{{ $drug->id }}">{{ $drug->generic_name }}{{ $drug->brand_name ? ' (' . $drug->brand_name . ')' : '' }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Select the first item you want to check.</div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="dashboard-drug-b-search" class="form-label fw-semibold">Medicine / food B</label>
                                <input
                                    id="dashboard-drug-b-search"
                                    type="search"
                                    class="form-control form-control-lg mb-2"
                                    placeholder="Search item B"
                                    autocomplete="off"
                                    data-select-search="dashboard-drug-b"
                                >
                                <select id="dashboard-drug-b" name="drug_b_id" class="form-select form-select-lg interaction-select" size="6" aria-label="Select second item">
                                    <option value="">Choose an item</option>
                                    @foreach ($drugs as $drug)
                                        <option value="{{ $drug->id }}">{{ $drug->generic_name }}{{ $drug->brand_name ? ' (' . $drug->brand_name . ')' : '' }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Select the second item you want to check.</div>
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

        <div class="col-12 col-xl-4" id="profile">
            <div class="card rounded-4 surface-soft border-0 h-100">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h4 fw-bold mb-3">Profile</h2>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="profile-avatar">{{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}</div>
                        <div>
                            <div class="fw-semibold">{{ $user?->name ?? 'User' }}</div>
                            <div class="text-muted small">{{ $user?->email ?? 'No email available' }}</div>
                        </div>
                    </div>
                    <div class="clinical-disclaimer rounded-4 p-3">
                        <p class="fw-semibold mb-1">Clinical disclaimer</p>
                        <p class="small mb-0">
                            This information supports but does not replace professional medical advice, judgment, or local prescribing policy.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7" id="recent-checks">
            <div class="card rounded-4 surface-soft border-0 h-100">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h4 fw-bold mb-3">Recent checks</h2>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Pair</th>
                                    <th>Severity</th>
                                    <th>Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentChecks as $check)
                                    <tr>
                                        <td class="fw-medium">{{ $check['pair'] }}</td>
                                        <td>
                                            <span class="badge text-bg-{{ $check['severity_class'] }}">{{ $check['severity_name'] }}</span>
                                        </td>
                                        <td class="text-muted">{{ $check['date'] }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('home') }}#checker" class="btn btn-sm btn-outline-primary">View again</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted">No recent checks are available yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5" id="saved-interactions">
            <div class="card rounded-4 surface-soft border-0 h-100">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                        <h2 class="h4 fw-bold mb-0">Saved interactions</h2>
                        <span class="badge text-bg-light text-primary">Placeholder data</span>
                    </div>
                    <p class="text-muted">
                        There is no saved-interactions table yet, so this section uses placeholder cards until that data model exists.
                    </p>

                    <div class="vstack gap-3">
                        @forelse ($savedInteractions as $saved)
                            <div class="saved-item rounded-4 p-3">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <div class="fw-semibold">{{ $saved['pair'] }}</div>
                                        <div class="small text-muted">{{ $saved['saved_at'] }}</div>
                                    </div>
                                    <span class="badge text-bg-{{ $saved['severity_class'] }}">{{ $saved['severity_name'] }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light border mb-0">
                                No saved interactions have been added yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="alert alert-warning rounded-4 clinical-disclaimer mb-0" role="alert">
                This data is intended to support clinical review, not replace professional medical advice or local policy.
            </div>
        </div>
    </div>
@endsection
