<?php


namespace App\Repositories;

use App\Models\Livro;

class LivroRepository extends BaseRepository
{
    protected Livro $livro;

    public function __construct(Livro $livro)
    {
        parent::__construct($livro);
        $this->livro = $livro;
    }

    public function withEmprestimos(int $livroId): object|null
    {
        return $this->livro::with('emprestimos')->find($livroId);
    }

    public function withAutor(int $livroId): object|null
    {
        return $this->livro::with('autor')->find($livroId);
    }

    public function withEditora(int $livroId): object|null
    {
        return $this->livro::with('editora')->find($livroId);
    }

}
