<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'firstname' => $this->input('data.firstname'),
            'lastname' => $this->input('data.lastname'),
            'phone' => $this->input('data.phone'),
            'email' => $this->input('data.email'),
            'address' => $this->input('data.address'),
            'city' => $this->input('data.city'),
            'state' => $this->input('data.state'),
            'zip' => $this->input('data.zip'),
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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/'],
            'email' =>
                [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($this->user)
                ],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'zip' => ['required', 'regex:/^[0-9]{5}(?:-[0-9]{4})?$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'city.required' => 'Vous devez insérer une ville.',
            'state.required' => 'Vous devez insérer un pays.',
            'address.required' => 'Vous devez insérer une adresse.',
            'zip.required' => 'Vous devez insérer un code postal.',
            'zip.regex' => 'Le code postal doit être au bon format.',
            'firstname.required' => 'Vous devez insérer un prénom.',
            'lastname.required' => 'Vous devez insérer un nom.',
            'phone.required' => 'Vous devez insérer un téléphone.',
            'phone.regex' => 'Le téléphone doit être au bon format.',
            'email.unique' => 'L\'e-mail est déjà existante.',
            'email.required' => 'Vous dever insérer une e-mail.',
            'email.email' => 'L\'e-mail doit être au bon format.',
        ];
    }
}
