<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Http\Requests\EmprestimoRequest;
use App\Services\EmprestimoService;
use Illuminate\Http\JsonResponse;

class EmprestimoController extends Controller
{
    protected EmprestimoService $emprestimoService;

    public function __construct(EmprestimoService $emprestimoService)
    {
        $this->emprestimoService = $emprestimoService;
    }

    public function index(): JsonResponse
    {
        try {
            $livros = $this->emprestimoService->todosRegistros();
            return response()->json(['data' => $livros]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function store(EmprestimoRequest $emprestimoRequest): JsonResponse
    {
        $this->emprestimoService->cadastrar($emprestimoRequest);
        return response()->json(['message' => 'Emprestimo cadastrado com sucesso!'], 201);
    }

    public function show(int $emprestimoId): JsonResponse
    {
        try {
            $emprestimo = $this->emprestimoService->detalhes($emprestimoId);
            return response()->json(['data' => $emprestimo]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function update(EmprestimoRequest $emprestimoRequest, int $emprestimoId): JsonResponse
    {
        try {
            $this->emprestimoService->editar($emprestimoId, $emprestimoRequest);
            return response()->json(['message' => 'Emprestimo atualizado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function destroy(int $emprestimoId): JsonResponse
    {
        try{
            $this->emprestimoService->deletar($emprestimoId);
            return response()->json(['message' => 'Emprestimo deletado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }
}
