<?php

namespace App\Services;

use App\Exceptions\JsonException;
use App\Http\Requests\LivroRequest;
use App\Repositories\LivroRepository;

class LivroService
{
    protected LivroRepository $livroRepository;


    public function __construct(LivroRepository $livroRepository)
    {
        $this->livroRepository = $livroRepository;
    }

    public function cadastrar(LivroRequest $livroRequest): object
    {
        $validate = $livroRequest->validated();
        return $this->livroRepository->save($validate);
    }

    public function todosRegistros(): object
    {
        $livros = $this->livroRepository->all();
        if($livros->isEmpty()){
            throw new JsonException('Não foram encontrados registros de livros!');
        }
        return $livros;
    }

    public function detalhes(int $autorId): object|null
    {
        $autor = $this->livroRepository->find($autorId);
        if(!$autor){
            throw new JsonException('Não foi possível buscar o livro!');
        }
        return $autor;
    }

    public function editar(int $autorId, LivroRequest $livroRequest): bool
    {
        $validate = $livroRequest->validated();
        if(!$this->livroRepository->update($autorId, $validate)){
            throw new JsonException('Não foi possível atualizar o livro!');
        }
        return true;
    }

    public function deletar(int $autorId): bool
    {
        if(!$this->livroRepository->delete($autorId)){
            throw new JsonException('Não foi possível deletar o livro!');
        }
        return true;
    }
}
