@php
    $drug = $drug ?? null;
@endphp

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="generic_name" class="form-label fw-semibold">Generic name</label>
        <input
            type="text"
            id="generic_name"
            name="generic_name"
            class="form-control @error('generic_name') is-invalid @enderror"
            value="{{ old('generic_name', $drug?->generic_name) }}"
            maxlength="255"
            required
        >
        @error('generic_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="brand_name" class="form-label fw-semibold">Brand name</label>
        <input
            type="text"
            id="brand_name"
            name="brand_name"
            class="form-control @error('brand_name') is-invalid @enderror"
            value="{{ old('brand_name', $drug?->brand_name) }}"
            maxlength="255"
        >
        @error('brand_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="drug_class" class="form-label fw-semibold">Drug class</label>
        <input
            type="text"
            id="drug_class"
            name="drug_class"
            class="form-control @error('drug_class') is-invalid @enderror"
            value="{{ old('drug_class', $drug?->drug_class) }}"
            maxlength="255"
        >
        @error('drug_class')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="dosage_form" class="form-label fw-semibold">Dosage form</label>
        <input
            type="text"
            id="dosage_form"
            name="dosage_form"
            class="form-control @error('dosage_form') is-invalid @enderror"
            value="{{ old('dosage_form', $drug?->dosage_form) }}"
            maxlength="255"
        >
        @error('dosage_form')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="strength" class="form-label fw-semibold">Strength</label>
        <input
            type="text"
            id="strength"
            name="strength"
            class="form-control @error('strength') is-invalid @enderror"
            value="{{ old('strength', $drug?->strength) }}"
            maxlength="255"
        >
        @error('strength')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="is_active" class="form-label fw-semibold">Active status</label>
        <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
            <option value="1" @selected(old('is_active', $drug?->is_active === false ? '0' : '1') === '1')>Active</option>
            <option value="0" @selected(old('is_active', $drug?->is_active === false ? '0' : '1') === '0')>Inactive</option>
        </select>
        @error('is_active')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label fw-semibold">Description</label>
        <textarea
            id="description"
            name="description"
            rows="3"
            class="form-control @error('description') is-invalid @enderror"
        >{{ old('description', $drug?->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="contraindications" class="form-label fw-semibold">Contraindications</label>
        <textarea
            id="contraindications"
            name="contraindications"
            rows="3"
            class="form-control @error('contraindications') is-invalid @enderror"
        >{{ old('contraindications', $drug?->contraindications) }}</textarea>
        @error('contraindications')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="warnings" class="form-label fw-semibold">Warnings</label>
        <textarea
            id="warnings"
            name="warnings"
            rows="3"
            class="form-control @error('warnings') is-invalid @enderror"
        >{{ old('warnings', $drug?->warnings) }}</textarea>
        @error('warnings')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="storage_information" class="form-label fw-semibold">Storage information</label>
        <textarea
            id="storage_information"
            name="storage_information"
            rows="3"
            class="form-control @error('storage_information') is-invalid @enderror"
        >{{ old('storage_information', $drug?->storage_information) }}</textarea>
        @error('storage_information')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
