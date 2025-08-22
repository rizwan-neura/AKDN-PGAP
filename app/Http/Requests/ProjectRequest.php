<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
                'type_id' => ['required'],
                'construction_cost' => ['required', 'numeric', 'min:0']
            ];
        }

        return $rules;
    }      
    public function messages()
    {
        return [
            'phase_id.required' => 'Please select Current Phase.',
            'organization_id.required' => 'Please select Organization.',
            'date_gpa.required' => 'Please enter Date of GBA* Performance.',
            'start_date.required' => 'Please enter Start Date.',
            'end_date.required' => 'Please enter End Date.',
            'type_id.required' => 'Please select Building Type.',
            'construction_cost.required' => 'Please enter Construction Cost (USD).',

            'cost_at_design.required' => 'Please enter Cost at Design phase.',
            'cost_at_construction.required' => 'Please enter Cost at Construction phase.',
            'cost_phase.required' => 'Cost phase is required.',
            'cost_phase.in' => 'Invalid cost phase selected.',
            'updatedProjectId.required' => 'Project ID is required.',
            'updatedProjectId.exists' => 'The selected project does not exist.',
        ];
    }
}
