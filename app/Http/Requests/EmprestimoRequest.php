<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmprestimoRequest extends FormRequest
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
            'id_livro' => ['required', 'exists:livros,id']
        ];
    }

    protected function update(): array
    {
        return [
            'id_user' => ['exists:users,id'],
            'id_livro' => ['exists:livros,id']
        ];
    }
}
