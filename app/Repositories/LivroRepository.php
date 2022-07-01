<?php


namespace App\Repositories;

use App\Models\Livro;

class LivroRepository extends BaseRepository
{
    protected Livro $livro;

    public function __construct(Livro $livro)
    {
        parent::__construct($livro);
    }


}
