<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentsRequest extends FormRequest
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
            'comments' => 'required',
            'indicator_id' => 'required',
            'updatedProjectId' => 'required',
        ];

        return $rules;
    }
   
    public function messages()
    {
        
        // Custom messages
        return [
            'comments.required' => 'Please enter the comment!',
            'indicator_id.required' => 'Please check indicator id is missing',
            'updatedProjectId.required' => 'Please check project id is missing',
        ];
    }
}
