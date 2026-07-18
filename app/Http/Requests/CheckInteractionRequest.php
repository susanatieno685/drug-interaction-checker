<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckInteractionRequest extends FormRequest
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
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'drug_a_id' => ['required', 'integer', 'exists:drugs,id'],
            'drug_b_id' => [
                'required',
                'integer',
                'exists:drugs,id',
                'different:drug_a_id',
            ],
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'drug_a_id.required' => 'Please choose the first drug.',
            'drug_a_id.integer' => 'The first drug selection must be valid.',
            'drug_a_id.exists' => 'The first drug could not be found in the database.',
            'drug_b_id.required' => 'Please choose the second drug.',
            'drug_b_id.integer' => 'The second drug selection must be valid.',
            'drug_b_id.exists' => 'The second drug could not be found in the database.',
            'drug_b_id.different' => 'Please choose two different drugs.',
        ];
    }
}
