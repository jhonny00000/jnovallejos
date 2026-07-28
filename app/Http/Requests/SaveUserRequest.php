<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SaveUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')?->id;
        $passwordRules = $this->isMethod('post')
            ? ['required', Password::defaults()]
            : ['nullable', Password::defaults()];

        return [
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'a_paterno' => ['required', 'string', 'max:255'],
            'a_materno' => ['nullable', 'string', 'max:255'],
            'ci' => ['required', 'string', 'max:50', Rule::unique('users', 'ci')->ignore($userId)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => $passwordRules,
        ];
    }
}
