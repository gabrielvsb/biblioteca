<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Http\Requests\LoanRequest;
use App\Services\LoanService;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    protected LoanService $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index(): JsonResponse
    {
        try {
            $livros = $this->loanService->allRecords();
            return response()->json(['data' => $livros]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function store(LoanRequest $loanRequest): JsonResponse
    {
        $this->loanService->register($loanRequest);
        return response()->json(['message' => 'Emprestimo cadastrado com sucesso!'], 201);
    }

    public function show(int $loanId): JsonResponse
    {
        try {
            $loan = $this->loanService->details($loanId);
            return response()->json(['data' => $loan]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function showWithUser(int $loanId): JsonResponse
    {
        try {
            $loan = $this->loanService->detailsWithUser($loanId);
            return response()->json(['data' => $loan]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function showWithBook(int $loanId): JsonResponse
    {
        try {
            $loan = $this->loanService->detailsWithBook($loanId);
            return response()->json(['data' => $loan]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function complete(int $loanId): JsonResponse
    {
        try {
            $loan = $this->loanService->detailsComplete($loanId);
            return response()->json(['data' => $loan]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function update(LoanRequest $loanRequest, int $loanId): JsonResponse
    {
        try {
            $this->loanService->edit($loanId, $loanRequest);
            return response()->json(['message' => 'Emprestimo atualizado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function destroy(int $loanId): JsonResponse
    {
        try{
            $this->loanService->delete($loanId);
            return response()->json(['message' => 'Emprestimo deletado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }
}
