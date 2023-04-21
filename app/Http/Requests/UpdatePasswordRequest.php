<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'old_password' => $this->input('data.old_password'),
            'password' => $this->input('data.password'),
            'password_confirmation' => $this->input('data.password_confirmation'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user()->password)) {
                        $fail(__('Le mot de passe actuel ne correspond pas.'));
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Vous devez insérer un mot de passe.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password_confirmation.required' => 'Vous devez confirmer le mot de passe.',
            'password_confirmation.min' => 'Le mot de passe doit contenir au moins :min caractères.',
        ];
    }
}
