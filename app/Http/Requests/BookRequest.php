<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => ['required', 'string', 'max:200', 'min:3'],
            'description' => ['string', 'max:255'],
            'release_date' => ['required', 'before_or_equal:today', 'date'],
            'id_publisher' => ['required', 'exists:publishers,id'],
            'active' => ['boolean'],
            'id_author' => ['required', 'exists:authors,id'],
        ];
    }

    protected function update(): array
    {
        return [
            'name' => ['string', 'max:200', 'min:3'],
            'description' => ['string', 'max:255'],
            'release_date' => ['before_or_equal:today', 'date'],
            'id_publisher' => ['exists:publishers,id'],
            'active' => ['boolean'],
            'id_author' => ['exists:authors,id'],
        ];
    }
}
