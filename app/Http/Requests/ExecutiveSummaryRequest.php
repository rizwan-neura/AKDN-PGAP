<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecutiveSummaryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'executive_summary' => ['required'],
            'updatedProjectId' => ['required', 'exists:projects,id'],
        ];
    }

    public function messages()
    {
        return [
            'executive_summary.required' => 'Please enter summary.',
            'updatedProjectId.required' => 'Project ID is required.',
            'updatedProjectId.exists' => 'The selected project does not exist.',
        ];
    }
}
