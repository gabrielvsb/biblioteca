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
        try {
            $editora = $this->editoraService->detalhes($editoraId);
            return response()->json(['data' => $editora]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function update(EditoraRequest $editoraRequest, int $editoraId): JsonResponse
    {
        try {
            $this->editoraService->editar($editoraId, $editoraRequest);
            return response()->json(['message' => 'Editora atualizada com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 400);
        }
    }

    public function destroy(int $editoraId): JsonResponse
    {
        try{
            $this->editoraService->deletar($editoraId);
            return response()->json(['message' => 'Editora deletada com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 400);
        }
    }
}
