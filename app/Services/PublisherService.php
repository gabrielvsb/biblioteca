<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\JsonException;
use App\Repositories\PublisherRepository;
use App\Http\Requests\PublisherRequest;

class PublisherService
{
    protected PublisherRepository $publisherRepository;

    public function __construct(PublisherRepository $publisherRepository)
    {
        $this->publisherRepository = $publisherRepository;
    }

    public function register(PublisherRequest $publisherRequest): object
    {
        $validate = $publisherRequest->validated();
        return $this->publisherRepository->save($validate);
    }

    public function allRecords(): object
    {
        $publishers = $this->publisherRepository->all();
        if($publishers->isEmpty()){
            throw new JsonException('Não foram encontrados registros de editoras!');
        }
        return $publishers;
    }

    public function details(int $publisherId): object|null
    {
        $publisher = $this->publisherRepository->find($publisherId);
        if(!$publisher){
            throw new JsonException('Não foi possível buscar a editora!');
        }
        return $publisher;
    }

    public function detailsWithBooks(int $publisherId): object|null
    {
        $publisher = $this->publisherRepository->withBooks($publisherId);
        if(!$publisher){
            throw new JsonException('Não foi possível buscar a editora!');
        }
        return $publisher;
    }

    public function edit(int $publisherId, PublisherRequest $publisherRequest): bool
    {
        $validate = $publisherRequest->validated();
        if(!$this->publisherRepository->update($publisherId, $validate)){
            throw new JsonException('Não foi possível atualizar a editora!');
        }
        return true;
    }

    public function delete(int $publisherId): bool
    {
        if(!$this->publisherRepository->delete($publisherId)){
            throw new JsonException('Não foi possível deletar a editora!');
        }
        return true;
    }
}
