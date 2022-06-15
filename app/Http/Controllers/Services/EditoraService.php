<?php
declare(strict_types=1);

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Repositories\EditoraRepository;
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
        return $this->editoraRepository->all();
    }

    public function detalhes(int $editoraId): object|null
    {
        return $this->editoraRepository->find($editoraId);
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
