<?php


namespace App\Services;

use App\Exceptions\JsonException;
use App\Http\Requests\LoanRequest;
use App\Repositories\LoanRepository;
use Carbon\Carbon;

class LoanService
{
    protected LoanRepository $loanRepository;

    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function register(LoanRequest $loanRequest): object
    {
        $validate = $loanRequest->validated();
        $validate['date_start'] = Carbon::now()->format('Y-m-d');
        $validate['date_end'] = Carbon::now()->addWeekdays(10)->format('Y-m-d');
        return $this->loanRepository->save($validate);
    }

    public function allRecords(): object
    {
        $loans = $this->loanRepository->all();
        if($loans->isEmpty()){
            throw new JsonException('Não foram encontrados registros de emprestimoss!');
        }
        return $loans;
    }

    public function details(int $loanId): object|null
    {
        $loan = $this->loanRepository->find($loanId);
        if(!$loan){
            throw new JsonException('Não foi possível buscar o emprestimo!');
        }
        return $loan;
    }

    public function detailsWithUser(int $loanId): object|null
    {
        $loan = $this->loanRepository->withUser($loanId);
        if(!$loan){
            throw new JsonException('Não foi possível buscar o emprestimo com detalhes de usuário!');
        }
        return $loan;
    }

    public function detailsWithBook(int $loanId): object|null
    {
        $loan = $this->loanRepository->withBook($loanId);
        if(!$loan){
            throw new JsonException('Não foi possível buscar o emprestimo com detalhes de livro!');
        }
        return $loan;
    }

    public function detailsComplete(int $loanId): object|null
    {
        $loan = $this->loanRepository->complete($loanId);
        if(!$loan){
            throw new JsonException('Não foi possível buscar o emprestimo com detalhes completo!');
        }
        return $loan;
    }

    public function edit(int $loanId, LoanRequest $loanRequest): bool
    {
        $validate = $loanRequest->validated();
        if(!$this->loanRepository->update($loanId, $validate)){
            throw new JsonException('Não foi possível atualizar o emprestimo!');
        }
        return true;
    }

    public function delete(int $loanId): bool
    {
        if(!$this->loanRepository->delete($loanId)){
            throw new JsonException('Não foi possível deletar o emprestimo!');
        }
        return true;
    }
}
