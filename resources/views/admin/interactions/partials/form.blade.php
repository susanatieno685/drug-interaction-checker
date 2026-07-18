@php
    $interaction = $interaction ?? null;
@endphp

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="drug_a_search" class="form-label fw-semibold">Drug A search</label>
        <input
            type="search"
            id="drug_a_search"
            class="form-control mb-2"
            placeholder="Search drug A"
            autocomplete="off"
            data-select-search="drug-a"
        >
        <label for="drug_a_id" class="visually-hidden">Drug A</label>
        <select id="drug_a_id" name="drug_a_id" class="form-select @error('drug_a_id') is-invalid @enderror" size="6" required>
            <option value="">Choose a drug</option>
            @foreach ($drugs as $drug)
                <option value="{{ $drug->id }}" @selected(old('drug_a_id', $interaction?->drug_a_id) == $drug->id)>
                    {{ $drug->generic_name }}{{ $drug->brand_name ? ' (' . $drug->brand_name . ')' : '' }}
                </option>
            @endforeach
        </select>
        @error('drug_a_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="drug_b_search" class="form-label fw-semibold">Drug B search</label>
        <input
            type="search"
            id="drug_b_search"
            class="form-control mb-2"
            placeholder="Search drug B"
            autocomplete="off"
            data-select-search="drug-b"
        >
        <label for="drug_b_id" class="visually-hidden">Drug B</label>
        <select id="drug_b_id" name="drug_b_id" class="form-select @error('drug_b_id') is-invalid @enderror" size="6" required>
            <option value="">Choose a drug</option>
            @foreach ($drugs as $drug)
                <option value="{{ $drug->id }}" @selected(old('drug_b_id', $interaction?->drug_b_id) == $drug->id)>
                    {{ $drug->generic_name }}{{ $drug->brand_name ? ' (' . $drug->brand_name . ')' : '' }}
                </option>
            @endforeach
        </select>
        @error('drug_b_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="interaction_severity_id" class="form-label fw-semibold">Severity</label>
        <select id="interaction_severity_id" name="interaction_severity_id" class="form-select @error('interaction_severity_id') is-invalid @enderror" required>
            <option value="">Choose severity</option>
            @foreach ($severities as $severity)
                <option value="{{ $severity->id }}" @selected(old('interaction_severity_id', $interaction?->interaction_severity_id) == $severity->id)>
                    {{ $severity->name }}
                </option>
            @endforeach
        </select>
        @error('interaction_severity_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="is_active" class="form-label fw-semibold">Active status</label>
        <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
            <option value="1" @selected(old('is_active', $interaction?->is_active === false ? '0' : '1') === '1')>Active</option>
            <option value="0" @selected(old('is_active', $interaction?->is_active === false ? '0' : '1') === '0')>Inactive</option>
        </select>
        @error('is_active')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="mechanism" class="form-label fw-semibold">Mechanism</label>
        <textarea id="mechanism" name="mechanism" rows="3" class="form-control @error('mechanism') is-invalid @enderror" required>{{ old('mechanism', $interaction?->mechanism) }}</textarea>
        @error('mechanism')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="clinical_effect" class="form-label fw-semibold">Clinical effect</label>
        <textarea id="clinical_effect" name="clinical_effect" rows="3" class="form-control @error('clinical_effect') is-invalid @enderror" required>{{ old('clinical_effect', $interaction?->clinical_effect) }}</textarea>
        @error('clinical_effect')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="management" class="form-label fw-semibold">Management recommendation</label>
        <textarea id="management" name="management" rows="3" class="form-control @error('management') is-invalid @enderror" required>{{ old('management', $interaction?->management) }}</textarea>
        @error('management')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="monitoring_advice" class="form-label fw-semibold">Monitoring advice</label>
        <textarea id="monitoring_advice" name="monitoring_advice" rows="3" class="form-control @error('monitoring_advice') is-invalid @enderror">{{ old('monitoring_advice', $interaction?->monitoring_advice) }}</textarea>
        @error('monitoring_advice')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="evidence_level" class="form-label fw-semibold">Evidence level</label>
        <input type="text" id="evidence_level" name="evidence_level" class="form-control @error('evidence_level') is-invalid @enderror" value="{{ old('evidence_level', $interaction?->evidence_level) }}" maxlength="255">
        @error('evidence_level')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="reference" class="form-label fw-semibold">Reference</label>
        <textarea id="reference" name="reference" rows="3" class="form-control @error('reference') is-invalid @enderror">{{ old('reference', $interaction?->reference) }}</textarea>
        @error('reference')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="notes" class="form-label fw-semibold">Notes</label>
        <textarea id="notes" name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $interaction?->notes) }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
