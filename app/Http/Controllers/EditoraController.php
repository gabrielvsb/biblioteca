<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Services\EditoraService;
use App\Http\Requests\EditoraRequest;
use Illuminate\Http\JsonResponse;

class EditoraController extends Controller
{
    protected EditoraService $editoraService;

    public function __construct(EditoraService $editoraService)
    {
        $this->editoraService = $editoraService;
    }

    public function index(): JsonResponse
    {
        $editoras = $this->editoraService->todosRegistros();
        if ($editoras->isNull()){
            return response()->json(['message' => 'Não foram encontrados registros de editoras!'], 404);
        }
        return response()->json(['data' => $editoras]);
    }

    public function store(EditoraRequest $editoraRequest): JsonResponse
    {
        $this->editoraService->cadastrar($editoraRequest);
        return response()->json(['message' => 'Editora cadastrada com sucesso!'], 201);
    }

    public function show(int $editoraId): JsonResponse
    {
        $editora = $this->editoraService->detalhes($editoraId);
        if(!$editora){
            return response()->json(['message' => 'Não foram encontrados registros desta editora!'], 404);
        }
        return response()->json(['data' => $editora]);
    }

    public function update(EditoraRequest $editoraRequest, int $editoraId): JsonResponse
    {
        $this->editoraService->editar($editoraId, $editoraRequest);
        return response()->json(['message' => 'Editora atualizada com sucesso!'], 204);
    }

    public function destroy(int $editoraId): JsonResponse
    {
        $this->editoraService->deletar($editoraId);
        return response()->json(['message' => 'Editora deletada com sucesso!'], 204);
    }
}
