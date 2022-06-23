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
        if(!$editoras){
            throw new JsonException('Não foram encontrados registros de editoras!');
        }
        return $editoras;
    }

    public function detalhes(int $editoraId): object|null
    {
        return $this->editoraRepository->withBooks($editoraId);
    }

    public function editar(int $editoraId, EditoraRequest $editoraRequest): bool
    {
        $validate = $editoraRequest->validated();
        return $this->editoraRepository->update($editoraId, $validate);
    }

    public function deletar(int $editoraId): bool
    {
        return $this->editoraRepository->delete($editoraId);
    }
}
