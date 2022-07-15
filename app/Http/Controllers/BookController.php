<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Http\Requests\BookRequest;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(): JsonResponse
    {
        try {
            $books = $this->bookService->allRecords();
            return response()->json(['data' => $books]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function store(BookRequest $bookRequest): JsonResponse
    {
        $this->bookService->register($bookRequest);
        return response()->json(['message' => 'Livro cadastrado com sucesso!'], 201);
    }

    public function show(int $bookId): JsonResponse
    {
        try {
            $book = $this->bookService->details($bookId);
            return response()->json(['data' => $book]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function showWithCopies(int $bookId): JsonResponse
    {
        try {
            $book = $this->bookService->detailsWithCopies($bookId);
            return response()->json(['data' => $book]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function showWithAuthor(int $bookId): JsonResponse
    {
        try {
            $book = $this->bookService->detailsWithAuthor($bookId);
            return response()->json(['data' => $book]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function showWithPublisher(int $bookId): JsonResponse
    {
        try {
            $book = $this->bookService->detailsWithPublisher($bookId);
            return response()->json(['data' => $book]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function update(BookRequest $bookRequest, int $bookId): JsonResponse
    {
        try {
            $this->bookService->edit($bookId, $bookRequest);
            return response()->json(['message' => 'Livro atualizado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function destroy(int $bookId): JsonResponse
    {
        try{
            $this->bookService->delete($bookId);
            return response()->json(['message' => 'Livro deletado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }
}
