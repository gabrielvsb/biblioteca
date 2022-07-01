<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:200', 'min:3']
        ];
    }

    protected function update(): array
    {
        return [
            'nome'  => ['string', 'max:200', 'min:3']
        ];
    }
}
