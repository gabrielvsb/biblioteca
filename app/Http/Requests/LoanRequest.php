<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'id_user' => ['required', 'exists:users,id'],
            'id_copy' => ['required', 'exists:copies,id']
        ];
    }

    protected function update(): array
    {
        return [
            'id_user' => ['exists:users,id'],
            'id_copy' => ['exists:copies,id']
        ];
    }
}
