<?php

namespace App\Services;

use App\Exceptions\JsonException;
use App\Http\Requests\AutorRequest;
use App\Repositories\AutorRepository;

class AutorService
{
    protected AutorRepository $autorRepository;

    public function __construct(AutorRepository $autorRepository)
    {
        $this->autorRepository = $autorRepository;
    }

    public function cadastrar(AutorRequest $autorRequest): object
    {
        $validate = $autorRequest->validated();
        return $this->autorRepository->save($validate);
    }

    public function todosRegistros(): object
    {
        $autores = $this->autorRepository->all();
        if($autores->isEmpty()){
            throw new JsonException('Não foram encontrados registros de autores!');
        }
        return $autores;
    }

    public function detalhes(int $autorId): object|null
    {
        $autor = $this->autorRepository->find($autorId);
        if(!$autor){
            throw new JsonException('Não foi possível buscar o autor!');
        }
        return $autor;
    }

    public function editar(int $autorId, AutorRequest $autorRequest): bool
    {
        $validate = $autorRequest->validated();
        if(!$this->autorRepository->update($autorId, $validate)){
            throw new JsonException('Não foi possível atualizar o autor!');
        }
        return true;
    }

    public function deletar(int $autorId): bool
    {
        if(!$this->autorRepository->delete($autorId)){
            throw new JsonException('Não foi possível deletar o autor!');
        }
        return true;
    }
}
