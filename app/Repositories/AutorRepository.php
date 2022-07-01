<?php

namespace App\Repositories;

use App\Models\Autor;
use App\Models\Editora;

class AutorRepository extends BaseRepository
{
    protected Autor $autor;

    public function __construct(Autor $autor)
    {
        parent::__construct($autor);
        $this->autor = $autor;
    }

}
