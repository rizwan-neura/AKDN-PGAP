<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectRequest extends FormRequest
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
        // Default empty rules
        $rules = [];

        // If this is a cost update request, validate only cost fields
        if ($this->has('cost_phase')) {
            $rules['cost_phase'] = ['required', 'in:cost_at_design,cost_at_construction'];
            $rules['updatedProjectId'] = ['required', 'exists:projects,id'];

            if ($this->input('cost_phase') === 'cost_at_design') {
                $rules['cost_at_design'] = ['required', 'numeric', 'min:0'];
            } elseif ($this->input('cost_phase') === 'cost_at_construction') {
                $rules['cost_at_construction'] = ['required', 'numeric', 'min:0'];
            }
            return $rules; // Return early, no other rules needed
        }
       

        // Otherwise (normal project creation or full update)
        if ($this->isMethod('post')) {
            $rules = [
                'project_name' => [
                    'required', 'regex:/^[a-zA-Z0-9 ]+$/',
                    'string',
                    'min:3',
                    'max:100',
                    'unique:projects'
                ],
                'phase_id' => ['required'],
                'organization_id' => ['required'],
                'date_gpa' => ['required'],
                'start_date' => ['required'],
                'end_date' => ['required'],
                'country_code' => ['required'],
                'type_id' => ['required'],
                'construction_cost' => ['required', 'numeric', 'min:0'],
                
                'latitude' => [
                    'nullable',
                    'required_with:longitude',
                    'numeric',
                    'between:-90,90',
                ],
                'longitude' => [
                    'nullable',
                    'required_with:latitude',
                    'numeric',
                    'between:-180,180',
                ],
            ];
        }

        return $rules;
    }      
    public function messages()
    {
        return [
            'phase_id.required' => 'Please select current phase.',
            'organization_id.required' => 'Please select organization.',
            'date_gpa.required' => 'Please enter date of GBA* performance.',
            'start_date.required' => 'Please enter start date.',
            'end_date.required' => 'Please enter end date.',
            'country_code.required' => 'Please select country.',
            'type_id.required' => 'Please select building type.',
            'construction_cost.required' => 'Please enter construction cost (USD).',
            'coordinates.required' => 'Please coordinates in decimal...',

            'cost_at_design.required' => 'Please enter cost at design phase.',
            'cost_at_construction.required' => 'Please enter cost at construction phase.',
            'cost_phase.required' => 'Cost phase is required.',
            'cost_phase.in' => 'Invalid cost phase selected.',
            'updatedProjectId.required' => 'Project ID is required.',
            'updatedProjectId.exists' => 'The selected project does not exist.',
        ];
    }
}
