<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Http\Requests\AuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(): JsonResponse
    {
        try {
            $authors = $this->authorService->allRecords();
            return response()->json(['data' => $authors]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function store(AuthorRequest $authorRequest): JsonResponse
    {
        $this->authorService->register($authorRequest);
        return response()->json(['message' => 'Author cadastrado com sucesso!'], 201);
    }

    public function show(int $authorId): JsonResponse
    {
        try {
            $author = $this->authorService->details($authorId);
            return response()->json(['data' => $author]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function update(AuthorRequest $authorRequest, int $authorId): JsonResponse
    {
        try {
            $this->authorService->edit($authorId, $authorRequest);
            return response()->json(['message' => 'Author atualizado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function destroy(int $authorId): JsonResponse
    {
        try{
            $this->authorService->delete($authorId);
            return response()->json(['message' => 'Author deletado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }
}
