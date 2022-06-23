<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Services\EditoraService;
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
        try {
            $editoras = $this->editoraService->todosRegistros();
            return response()->json(['data' => $editoras]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
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
        $resposta = $this->editoraService->editar($editoraId, $editoraRequest);

        if(!$resposta){
            return response()->json(['message' => 'Não foi possível atualizar a editora!'], 400);
        }
        return response()->json(['message' => 'Editora atualizada com sucesso!']);
    }

    public function destroy(int $editoraId): JsonResponse
    {
        $resposta = $this->editoraService->deletar($editoraId);
        if(!$resposta){
            return response()->json(['message' => 'Não foi possível deletar a editora!'], 400);
        }
        return response()->json(['message' => 'Editora deletada com sucesso!']);
    }
}
