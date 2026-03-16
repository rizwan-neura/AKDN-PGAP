<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectChecklistRequest extends FormRequest
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
        
        $rules = [
            'checklistStatus' => 'required|in:YES,NO',
            'checklist_id' => 'required',
            'updatedProjectId' => 'required',
        ];

         // Conditionally add file validation
         if ($this->checklistStatus === 'YES' && ($this->checklist_id === "1" || $this->checklist_id === "2" || $this->checklist_id === "8" )) {
            $rules['checklist_uploads'] = 'required|file|mimes:pdf|max:2048';
        } else {
            $rules['checklist_uploads'] = 'nullable|file|mimes:pdf|max:2048';
        }

        return $rules;
    }

    
    public function messages()
    {
        
        // Custom messages
        return [
            'checklistStatus.required' => 'Please select a checklist status.',
            'checklist_uploads.required' => 'File upload is required when status is YES.',
            'checklist_uploads.mimes' => 'Only PDF files are allowed.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 422));
    }
}
