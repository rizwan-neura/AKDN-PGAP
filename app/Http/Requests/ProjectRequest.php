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
        //dd($this->step);
        if ($this->isMethod('post')) {
            $rules =  [
                'project_name' => [
                    'required', 'regex:/^[a-zA-Z0-9 ]+$/',
                    'string',
                    'min:3',
                    'max:100',
                    'unique:projects'
                ],
                'phase_id' => [
                    'required'
                ],
                'organization_id' => [
                    'required'
                ],
                'date_gpa' => [
                    'required'
                ],
                'start_date' => [
                    'required'
                ],
                'end_date' => [
                    'required'
                ],
                'type_id' => [
                    'required'
                ],
                'construction_cost' => [
                    'required',
                    'numeric',
                    'min:0',
                    'max:9999.99'
                ]
            ];
        } elseif ($this->isMethod('put')) {
            /*if ($this->route()->getActionMethod() == 'isActive') {
                $rules =  [
                    'is_active' => [
                        'required',
                        'in:true,false'
                    ]
                ];
            } 
                else {*/
                $rules =  [
                    'country_name' => [
                        'required',
                        'string',
                        'min:3',
                        'max:100',
                        'unique:countries,country_name,' . $this->country
                    ]
                ];
           // }
        } else {
            $rules = [];
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
        ];
    }
}
