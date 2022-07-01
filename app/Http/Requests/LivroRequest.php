<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:200', 'min:3'],
            'descricao' => ['string', 'max:255'],
            'data_lancamento' => ['required', 'before_or_equal:today', 'date'],
            'id_editora' => ['required', 'exists:editoras,id'],
            'quantidade_total' => ['required','digits_between:0,20'],
            'ativo' => ['boolean'],
            'id_autor' => ['required', 'exists:autores,id'],
        ];
    }

    protected function update(): array
    {
        return [
            'nome' => ['string', 'max:200', 'min:3'],
            'descricao' => ['string', 'max:255'],
            'data_lancamento' => ['before_or_equal:today', 'date'],
            'id_editora' => ['exists:editoras,id'],
            'quantidade_total' => ['digits_between:0,20'],
            'ativo' => ['boolean'],
            'id_autor' => ['exists:autores,id'],
        ];
    }
}
