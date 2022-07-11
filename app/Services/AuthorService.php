<?php

namespace App\Services;

use App\Exceptions\JsonException;
use App\Http\Requests\AuthorRequest;
use App\Repositories\AuthorRepository;

class AuthorService
{
    protected AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function register(AuthorRequest $authorRequest): object
    {
        $validate = $authorRequest->validated();
        return $this->authorRepository->save($validate);
    }

    public function allRecords(): object
    {
        $authors = $this->authorRepository->all();
        if($authors->isEmpty()){
            throw new JsonException('Não foram encontrados registros de autores!');
        }
        return $authors;
    }

    public function details(int $authorId): object|null
    {
        $author = $this->authorRepository->find($authorId);
        if(!$author){
            throw new JsonException('Não foi possível buscar o autor!');
        }
        return $author;
    }

    public function edit(int $authorId, AuthorRequest $authorRequest): bool
    {
        $validate = $authorRequest->validated();
        if(!$this->authorRepository->update($authorId, $validate)){
            throw new JsonException('Não foi possível atualizar o autor!');
        }
        return true;
    }

    public function delete(int $authorId): bool
    {
        if(!$this->authorRepository->delete($authorId)){
            throw new JsonException('Não foi possível deletar o autor!');
        }
        return true;
    }
}
