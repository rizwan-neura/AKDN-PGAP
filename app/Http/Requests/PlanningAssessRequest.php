<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlanningAssessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        $rules = [
            'compliance' => 'required',
            'indicator_id' => 'required',
            'updatedProjectId' => 'required',
        ];

         // if compliance is YES against these indicators and file is not uploaded, show error
         if ($this->compliance === '2' && ($this->indicator_id === "1" || $this->indicator_id === "4" || $this->indicator_id === "6" )) {
            $rules['planning_uploads'] = 'required|file|mimes:pdf|max:2048';
        }else if ($this->indicator_id === '4' && ($this->compliance === "4" || $this->compliance === "5" || $this->compliance === "6" || $this->compliance === "7" )) {
            $rules['planning_uploads'] = 'required|file|mimes:pdf|max:2048';
        } else {
            $rules['planning_uploads'] = 'nullable|file|mimes:pdf|max:2048';
        }

        return $rules;
    }
    /*
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Only apply this rule to indicator IDs 1, 4, and 6
            if (in_array($this->indicator_id, ['1', '4', '6']) && $this->compliance == '1') {
                $validator->errors()->add('compliance', 'Since mandatory requirement are not met therefore you are requested to comply and resubmit it.');
            }
        });
    }
    */
    public function messages()
    {
        
        // Custom messages
        return [
            'compliance.required' => 'Please select compliance.',
            'planning_uploads.required' => 'File upload is required when compliance is YES.',
            'planning_uploads.mimes' => 'Only PDF files are allowed.',
        ];
    }
}
