<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\JsonException;
use App\Repositories\EditoraRepository;
use App\Http\Requests\EditoraRequest;

class EditoraService
{
    protected EditoraRepository $editoraRepository;

    public function __construct(EditoraRepository $editoraRepository)
    {
        $this->editoraRepository = $editoraRepository;
    }

    public function cadastrar(EditoraRequest $editoraRequest): object
    {
        $validate = $editoraRequest->validated();
        return $this->editoraRepository->save($validate);
    }

    public function todosRegistros(): object
    {
        $editoras = $this->editoraRepository->all();
        if($editoras->isEmpty()){
            throw new JsonException('Não foram encontrados registros de editoras!');
        }
        return $editoras;
    }

    public function detalhes(int $editoraId): object|null
    {
        $editora = $this->editoraRepository->find($editoraId);
        if(!$editora){
            throw new JsonException('Não foi possível buscar a editora!');
        }
        return $editora;
    }

    public function detalhesComLivros(int $editoraId): object|null
    {
        $editora = $this->editoraRepository->withBooks($editoraId);
        if(!$editora){
            throw new JsonException('Não foi possível buscar a editora!');
        }
        return $editora;
    }

    public function editar(int $editoraId, EditoraRequest $editoraRequest): bool
    {
        $validate = $editoraRequest->validated();
        if(!$this->editoraRepository->update($editoraId, $validate)){
            throw new JsonException('Não foi possível atualizar a editora!');
        }
        return true;
    }

    public function deletar(int $editoraId): bool
    {
        if(!$this->editoraRepository->delete($editoraId)){
            throw new JsonException('Não foi possível deletar a editora!');
        }
        return true;
    }
}
