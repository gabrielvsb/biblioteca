<?php

namespace App\Repositories;


use App\Models\Editora;

class EditoraRepository extends BaseRepository
{
    protected Editora $editora;

    public function __construct(Editora $editora)
    {
        parent::__construct($editora);
        $this->editora = $editora;
    }

    public function withBooks(int $editoraId): object|null
    {
        return $this->editora::with('livros')->find($editoraId);
    }
}
