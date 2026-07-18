<?php

namespace App\Http\Requests;

use App\Models\Drug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDrugRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'generic_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Drug::class, 'generic_name'),
            ],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'drug_class' => ['nullable', 'string', 'max:255'],
            'dosage_form' => ['nullable', 'string', 'max:255'],
            'strength' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'contraindications' => ['nullable', 'string'],
            'warnings' => ['nullable', 'string'],
            'storage_information' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the custom error messages for the validator.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'generic_name.required' => 'Please enter the generic name.',
            'generic_name.string' => 'The generic name must be a text value.',
            'generic_name.max' => 'The generic name may not be longer than 255 characters.',
            'generic_name.unique' => 'A drug with this generic name already exists.',
            'brand_name.string' => 'The brand name must be a text value.',
            'brand_name.max' => 'The brand name may not be longer than 255 characters.',
            'drug_class.string' => 'The drug class must be a text value.',
            'drug_class.max' => 'The drug class may not be longer than 255 characters.',
            'dosage_form.string' => 'The dosage form must be a text value.',
            'dosage_form.max' => 'The dosage form may not be longer than 255 characters.',
            'strength.string' => 'The strength must be a text value.',
            'strength.max' => 'The strength may not be longer than 255 characters.',
            'description.string' => 'The description must be a text value.',
            'contraindications.string' => 'The contraindications must be a text value.',
            'warnings.string' => 'The warnings must be a text value.',
            'storage_information.string' => 'The storage information must be a text value.',
            'is_active.required' => 'Please choose whether this drug is active.',
            'is_active.boolean' => 'The active status must be yes or no.',
        ];
    }
}
