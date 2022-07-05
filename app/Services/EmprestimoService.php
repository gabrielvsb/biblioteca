<?php


namespace App\Services;

use App\Exceptions\JsonException;
use App\Http\Requests\EmprestimoRequest;
use App\Repositories\EmprestimoRepository;
use Carbon\Carbon;

class EmprestimoService
{
    protected EmprestimoRepository $emprestimoRepository;

    public function __construct(EmprestimoRepository $emprestimoRepository)
    {
        $this->emprestimoRepository = $emprestimoRepository;
    }

    public function cadastrar(EmprestimoRequest $emprestimoRequest): object
    {
        $validate = $emprestimoRequest->validated();
        $validate['data_inicio'] = Carbon::now()->format('Y-m-d');
        $validate['data_fim'] = Carbon::now()->addWeekdays(10)->format('Y-m-d');
        return $this->emprestimoRepository->save($validate);
    }

    public function todosRegistros(): object
    {
        $emprestimos = $this->emprestimoRepository->all();
        if($emprestimos->isEmpty()){
            throw new JsonException('Não foram encontrados registros de emprestimos!');
        }
        return $emprestimos;
    }

    public function detalhes(int $emprestimoId): object|null
    {
        $emprestimo = $this->emprestimoRepository->find($emprestimoId);
        if(!$emprestimo){
            throw new JsonException('Não foi possível buscar o emprestimo!');
        }
        return $emprestimo;
    }

    public function editar(int $emprestimoId, EmprestimoRequest $emprestimoRequest): bool
    {
        $validate = $emprestimoRequest->validated();
        if(!$this->emprestimoRepository->update($emprestimoId, $validate)){
            throw new JsonException('Não foi possível atualizar o emprestimo!');
        }
        return true;
    }

    public function deletar(int $emprestimoId): bool
    {
        if(!$this->emprestimoRepository->delete($emprestimoId)){
            throw new JsonException('Não foi possível deletar o emprestimo!');
        }
        return true;
    }
}
