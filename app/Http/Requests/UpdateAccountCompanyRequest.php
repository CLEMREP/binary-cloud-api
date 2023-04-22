<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/'],
            'email' =>
                [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('companies', 'email')->ignore($this->user->company)
                ],
            'siret' => ['numeric','digits:14','regex:/^[0-9]{3} ?[0-9]{3} ?[0-9]{3} ?[0-9]{5}$/'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'zip' => ['required', 'regex:/^[0-9]{5}(?:-[0-9]{4})?$/'],
            'image' =>
                [
                    'image',
                    'mimes:jpeg,png,jpg,svg',
                    'max:2048',
                    Rule::requiredIf($this->user->company->image === null)
                ],
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
            'name.required' => 'Vous devez insérer un nom d\'entreprise.',
            'phone.required' => 'Vous devez insérer un téléphone.',
            'phone.regex' => 'Le téléphone doit être au bon format.',
            'email.unique' => 'L\'e-mail est déjà existante.',
            'email.required' => 'Vous dever insérer une e-mail.',
            'email.email' => 'L\'e-mail doit être au bon format.',
            'siret.required' => 'Vous devez insérer un numéro de SIRET.',
            'siret.numeric' => 'Le numéro de SIRET doit être au bon format.',
            'siret.digits' => 'Le numéro de SIRET doit être au bon format.',
            'siret.regex' => 'Le numéro de SIRET doit être au bon format.',
            'image.required' => 'Vous devez insérer une image.',
            'image.image' => 'L\'image doit être au bon format.',
        ];
    }
}
