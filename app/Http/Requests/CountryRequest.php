<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            $rules =  [
                'country_name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'unique:countries'
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
}
