<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CopyRequest extends FormRequest
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
            'isbn' => ['required','string'],
            'id_book' => ['required','exists:books,id'],
            'status' => ['required','string'],
        ];
    }

    protected function update(): array
    {
        return [
            'isbn' => ['string'],
            'id_book' => ['exists:books,id'],
            'status' => ['string'],
        ];
    }
}
