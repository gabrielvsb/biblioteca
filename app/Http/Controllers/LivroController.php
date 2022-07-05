<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Http\Requests\LivroRequest;
use App\Services\LivroService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    protected LivroService $livroService;

    public function __construct(LivroService $livroService)
    {
        $this->livroService = $livroService;
    }

    public function index(): JsonResponse
    {
        try {
            $livros = $this->livroService->todosRegistros();
            return response()->json(['data' => $livros]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function store(LivroRequest $livroRequest): JsonResponse
    {
        $this->livroService->cadastrar($livroRequest);
        return response()->json(['message' => 'Livro cadastrado com sucesso!'], 201);
    }

    public function show(int $livroId): JsonResponse
    {
        try {
            $livro = $this->livroService->detalhes($livroId);
            return response()->json(['data' => $livro]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function showWithEmprestimos(int $livroId): JsonResponse
    {
        try {
            $livro = $this->livroService->detalhesComEmprestimos($livroId);
            return response()->json(['data' => $livro]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function showWithAutor(int $livroId): JsonResponse
    {
        try {
            $livro = $this->livroService->detalhesComAutor($livroId);
            return response()->json(['data' => $livro]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function showWithEditora(int $livroId): JsonResponse
    {
        try {
            $livro = $this->livroService->detalhesComEditora($livroId);
            return response()->json(['data' => $livro]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function update(LivroRequest $livroRequest, int $livroId): JsonResponse
    {
        try {
            $this->livroService->editar($livroId, $livroRequest);
            return response()->json(['message' => 'Livro atualizado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function destroy(int $livroId): JsonResponse
    {
        try{
            $this->livroService->deletar($livroId);
            return response()->json(['message' => 'Livro deletado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }
}
