<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:1', 'max:250'],
            'description' => ['required', 'string', 'min:1', 'max:255'],
            'expiration_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Názov je povinný.',
            'title.min' => 'Názov musí mať aspoň 1 znak.',
            'title.max' => 'Názov môže mať najviac 250 znakov.',
            'description.required' => 'Popis je povinný.',
            'description.min' => 'Popis musí mať aspoň 1 znak.',
            'description.max' => 'Popis môže mať najviac 255 znakov.',
            'expiration_date.required' => 'Dátum expirácie je povinný.',
            'expiration_date.date' => 'Dátum expirácie musí byť platný dátum.',
            'location.required' => 'Lokalita je povinná.',
            'category_id.required' => 'Kategória je povinná.',
            'category_id.exists' => 'Vybraná kategória neexistuje.',
            'image.image' => 'Súbor musí byť obrázok.',
            'image.mimes' => 'Povolené formáty sú: jpeg, jpg, png.',
            'image.max' => 'Maximálna veľkosť obrázka je 2 MB.',
        ];
    }
}
