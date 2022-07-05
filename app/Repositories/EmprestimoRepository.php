<?php


namespace App\Repositories;


use App\Models\Emprestimo;

class EmprestimoRepository extends BaseRepository
{
    protected Emprestimo $emprestimo;

    public function __construct(Emprestimo $emprestimo)
    {
        parent::__construct($emprestimo);
        $this->emprestimo = $emprestimo;
    }

    public function withUser(int $emprestimoId): object|null
    {
        return $this->emprestimo::with('usuario')->find($emprestimoId);
    }

    public function withBook(int $emprestimoId): object|null
    {
        return $this->emprestimo::with('livro')->find($emprestimoId);
    }

    public function complete(int $emprestimoId): object|null
    {
        return $this->emprestimo::with(['usuario', 'livro'])->find($emprestimoId);
    }


}
