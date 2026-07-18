<?php

namespace App\Http\Requests;

use App\Models\DrugInteraction;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDrugInteractionRequest extends FormRequest
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
            'drug_a_id' => ['required', 'integer', 'exists:drugs,id', 'different:drug_b_id'],
            'drug_b_id' => [
                'required',
                'integer',
                'exists:drugs,id',
                'different:drug_a_id',
                $this->uniqueNormalizedPairRule(),
            ],
            'interaction_severity_id' => ['required', 'integer', 'exists:interaction_severities,id'],
            'mechanism' => ['required', 'string'],
            'clinical_effect' => ['required', 'string'],
            'management' => ['required', 'string'],
            'monitoring_advice' => ['nullable', 'string'],
            'evidence_level' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    /**
     * Build a custom validation rule for normalized pair uniqueness.
     */
    protected function uniqueNormalizedPairRule(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail): void {
            $drugAId = (int) $this->input('drug_a_id');
            $drugBId = (int) $value;
            $interaction = $this->route('interaction');
            $interactionId = $interaction instanceof DrugInteraction ? $interaction->id : $interaction;

            if (! $drugAId || ! $drugBId || $drugAId === $drugBId) {
                return;
            }

            [$normalizedA, $normalizedB] = $drugAId < $drugBId
                ? [$drugAId, $drugBId]
                : [$drugBId, $drugAId];

            $exists = DrugInteraction::query()
                ->where('drug_a_id', $normalizedA)
                ->where('drug_b_id', $normalizedB)
                ->when($interactionId, fn ($query) => $query->where('id', '!=', $interactionId))
                ->exists();

            if ($exists) {
                $fail('This drug pair already has an interaction record.');
            }
        };
    }

    /**
     * Get the custom error messages for the validator.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'drug_a_id.required' => 'Please choose the first drug.',
            'drug_a_id.integer' => 'The first drug must be a valid selection.',
            'drug_a_id.exists' => 'The first drug could not be found in the database.',
            'drug_a_id.different' => 'Please choose two different drugs.',
            'drug_b_id.required' => 'Please choose the second drug.',
            'drug_b_id.integer' => 'The second drug must be a valid selection.',
            'drug_b_id.exists' => 'The second drug could not be found in the database.',
            'drug_b_id.different' => 'Please choose two different drugs.',
            'interaction_severity_id.required' => 'Please choose a severity.',
            'interaction_severity_id.integer' => 'The severity must be a valid selection.',
            'interaction_severity_id.exists' => 'The selected severity could not be found.',
            'mechanism.required' => 'Please enter the interaction mechanism.',
            'mechanism.string' => 'The mechanism must be text.',
            'clinical_effect.required' => 'Please enter the clinical effect.',
            'clinical_effect.string' => 'The clinical effect must be text.',
            'management.required' => 'Please enter the management recommendation.',
            'management.string' => 'The management recommendation must be text.',
            'monitoring_advice.string' => 'The monitoring advice must be text.',
            'evidence_level.string' => 'The evidence level must be text.',
            'evidence_level.max' => 'The evidence level may not be longer than 255 characters.',
            'reference.string' => 'The reference must be text.',
            'notes.string' => 'The notes must be text.',
            'is_active.required' => 'Please choose whether this interaction is active.',
            'is_active.boolean' => 'The active status must be yes or no.',
        ];
    }
}
