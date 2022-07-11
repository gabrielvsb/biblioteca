<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Exceptions\JsonException;
use App\Services\PublisherService;
use App\Http\Requests\PublisherRequest;
use Illuminate\Http\JsonResponse;

class PublisherController extends Controller
{
    protected PublisherService $publisherService;

    public function __construct(PublisherService $publisherService)
    {
        $this->publisherService = $publisherService;
    }

    public function index(): JsonResponse
    {
        try {
            $publishers = $this->publisherService->allRecords();
            return response()->json(['data' => $publishers]);
        }catch(JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }
    }

    public function store(PublisherRequest $publisherRequest): JsonResponse
    {
        $this->publisherService->register($publisherRequest);
        return response()->json(['message' => 'Editora cadastrada com sucesso!'], 201);
    }

    public function show(int $publisherId): JsonResponse
    {
        try {
            $publisher = $this->publisherService->details($publisherId);
            return response()->json(['data' => $publisher]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function showWithBooks(int $publisherId): JsonResponse
    {
        try {
            $publisher = $this->publisherService->detailsWithBooks($publisherId);
            return response()->json(['data' => $publisher]);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 404);
        }

    }

    public function update(PublisherRequest $publisherRequest, int $publisherId): JsonResponse
    {
        try {
            $this->publisherService->edit($publisherId, $publisherRequest);
            return response()->json(['message' => 'Editora atualizada com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 400);
        }
    }

    public function destroy(int $publisherId): JsonResponse
    {
        try{
            $this->publisherService->delete($publisherId);
            return response()->json(['message' => 'Editora deletada com sucesso!']);
        }catch (JsonException $jsonException){
            return response()->json(['message' => $jsonException->getMessage()], 400);
        }
    }
}
