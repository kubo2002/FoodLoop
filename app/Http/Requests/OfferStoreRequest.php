<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Povoliť iba prihláseným donorom; jednoduchá kontrola v kontroléri už beží,
        // tu stačí, že je prihlásený používateľ.
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
            'title.min' => 'Názov musí mať aspoň 3 znaky.',
            'description.required' => 'Popis je povinný.',
            'location.required' => 'Lokalita je povinná.',
            'category_id.required' => 'Kategória je povinná.',
            'category_id.exists' => 'Vybraná kategória neexistuje.',
            'image.image' => 'Súbor musí byť obrázok.',
            'image.mimes' => 'Povolené formáty sú: jpeg, jpg, png.',
            'image.max' => 'Maximálna veľkosť obrázka je 2 MB.',
        ];
    }
}
