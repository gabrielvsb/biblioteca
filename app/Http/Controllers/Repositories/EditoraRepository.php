<?php
declare(strict_types=1);
namespace App\Http\Controllers\Repositories;


use App\Models\Editora;

class EditoraRepository extends BaseRepository
{
    protected Editora $editora;

    public function __construct(Editora $editora)
    {
        parent::__construct($editora);
    }
}
