<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConstructionAssessRequest extends FormRequest
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
        /*
         if ($this->compliance === '2' && ($this->indicator_id === "2" || $this->indicator_id === "3" || $this->indicator_id === "5" || $this->indicator_id === "6" 
         || $this->indicator_id === "7" || $this->indicator_id === "9" || $this->indicator_id === "10" || $this->indicator_id === "11"
         || $this->indicator_id === "14" || $this->indicator_id === "15" || $this->indicator_id === "16")) {
            $rules['cons_uploads'] = 'required|file|mimes:pdf|max:2048';
        }else {
            $rules['cons_uploads'] = 'nullable|file|mimes:pdf|max:2048';
        }
            */

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
            'compliance.required' => 'Please select a compliance.',
            'cons_uploads.required' => 'File upload is required when status is YES.',
            'cons_uploads.mimes' => 'Only PDF files are allowed.',
        ];
    }
}
