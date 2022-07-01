<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Http\Requests\AutorRequest;
use App\Services\AutorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    protected AutorService $autorService;

    public function __construct(AutorService $autorService)
    {
        $this->autorService = $autorService;
    }

    public function index(): JsonResponse
    {
        try {
            $autores = $this->autorService->todosRegistros();
            return response()->json(['data' => $autores]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function store(AutorRequest $autorRequest): JsonResponse
    {
        $this->autorService->cadastrar($autorRequest);
        return response()->json(['message' => 'Autor cadastrado com sucesso!'], 201);
    }

    public function show(int $autorId): JsonResponse
    {
        try {
            $autor = $this->autorService->detalhes($autorId);
            return response()->json(['data' => $autor]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function update(AutorRequest $autorRequest, int $autorId): JsonResponse
    {
        try {
            $this->autorService->editar($autorId, $autorRequest);
            return response()->json(['message' => 'Autor atualizado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function destroy(int $autorId): JsonResponse
    {
        try{
            $this->autorService->deletar($autorId);
            return response()->json(['message' => 'Autor deletado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }
}
