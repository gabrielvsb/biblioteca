<?php


namespace App\Http\Controllers\Repositories;


use App\Models\Livro;

class LivroRepository extends BaseRepository
{
    protected $livro;

    /**
     * LivroRepository constructor.
     * @param Livro $livro
     */
    public function __construct(Livro $livro)
    {
        parent::__construct($livro);
    }


}
