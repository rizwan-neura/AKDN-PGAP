<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name' => trim((string) $this->input('first_name')),
            'last_name' => trim((string) $this->input('last_name')),
            'username' => trim((string) $this->input('username')),
            'email' => strtolower(trim((string) $this->input('email'))),
            'status' => trim((string) $this->input('status')),
        ]);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'organization_id' => ['required', 'integer', 'exists:organizations,id'],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')->where(fn ($query) => $query->where('is_active', true)),
            ],
            'status' => ['required', Rule::in(User::STATUSES)],
            'password' => ['required', 'string', Password::min(8)],
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => 'This username is already being used.',
            'email.unique' => 'This email address is already registered.',
            'organization_id.required' => 'Please select an organization.',
            'organization_id.exists' => 'The selected organization is invalid.',
            'role_id.required' => 'Please select a role.',
            'role_id.exists' => 'The selected role is invalid or inactive.',
            'status.in' => 'Please select a valid status.',
            'password.min' => 'Password must be at least 8 characters.',
        ];
    }
}
