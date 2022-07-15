<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Http\Requests\CopyRequest;
use App\Services\CopyService;
use Illuminate\Http\JsonResponse;

class CopyController extends Controller
{
    protected CopyService $copyService;

    public function __construct(CopyService $copyService)
    {
        $this->copyService = $copyService;
    }

    public function index(): JsonResponse
    {
        try {
            $copies = $this->copyService->allRecords();
            return response()->json(['data' => $copies]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function store(CopyRequest $copyRequest): JsonResponse
    {
        $this->copyService->register($copyRequest);
        return response()->json(['message' => 'Exemplar cadastrado com sucesso!'], 201);
    }

    public function show(int $copyId): JsonResponse
    {
        try {
            $copy = $this->copyService->details($copyId);
            return response()->json(['data' => $copy]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function update(CopyRequest $copyRequest, int $copyId): JsonResponse
    {
        try {
            $this->copyService->edit($copyId, $copyRequest);
            return response()->json(['message' => 'Exemplar atualizado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function destroy(int $copyId): JsonResponse
    {
        try{
            $this->copyService->delete($copyId);
            return response()->json(['message' => 'Exemplar deletado com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }
}
