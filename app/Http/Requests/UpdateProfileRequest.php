<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Povoliť len prihláseným používateľom
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'role'  => ['sometimes', Rule::in(['donor', 'recipient'])],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Meno je povinné.',
            'email.required' => 'Email je povinný.',
            'email.email' => 'Email musí mať platný formát.',
            'email.unique' => 'Tento email už existuje.',
            'role.required' => 'Rola je povinná.',
            'role.in' => 'Rola musí byť donor alebo recipient.',
            'photo.image' => 'Súbor musí byť obrázok.',
            'photo.mimes' => 'Povolené formáty sú: jpeg, jpg, png.',
            'photo.max' => 'Maximálna veľkosť obrázka je 2 MB.',
        ];
    }
}
