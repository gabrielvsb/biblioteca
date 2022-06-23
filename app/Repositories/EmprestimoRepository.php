<?php


namespace App\Repositories;


use App\Models\Emprestimo;

class EmprestimoRepository extends BaseRepository
{
    protected $emprestimo;

    /**
     * EmprestimoRepository constructor.
     * @param Emprestimo $emprestimo
     */
    public function __construct(Emprestimo $emprestimo)
    {
        parent::__construct($emprestimo);
    }


}
