<?php

namespace App\Services;

use App\Exceptions\JsonException;
use App\Http\Requests\CopyRequest;
use App\Repositories\CopyRepository;

class CopyService
{
    protected CopyRepository $copyRepository;

    public function __construct(copyRepository $copyRepository)
    {
        $this->copyRepository = $copyRepository;
    }

    public function register(CopyRequest $copyRequest): object
    {
        $validate = $copyRequest->validated();
        return $this->copyRepository->save($validate);
    }

    public function allRecords(): object
    {
        $copies = $this->copyRepository->all();
        if($copies->isEmpty()){
            throw new JsonException('Não foram encontrados registros de exemplares!');
        }
        return $copies;
    }

    public function details(int $copyId): object|null
    {
        $copy = $this->copyRepository->find($copyId);
        if(!$copy){
            throw new JsonException('Não foi possível buscar o exemplar!');
        }
        return $copy;
    }

    public function edit(int $copyId, CopyRequest $copyRequest): bool
    {
        $validate = $copyRequest->validated();
        if(!$this->copyRepository->update($copyId, $validate)){
            throw new JsonException('Não foi possível atualizar o exemplar!');
        }
        return true;
    }

    public function delete(int $copyId): bool
    {
        if(!$this->copyRepository->delete($copyId)){
            throw new JsonException('Não foi possível deletar o exemplar!');
        }
        return true;
    }
}
