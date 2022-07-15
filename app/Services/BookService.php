<?php

namespace App\Services;

use App\Exceptions\JsonException;
use App\Http\Requests\BookRequest;
use App\Repositories\BookRepository;

class BookService
{
    protected BookRepository $bookRepository;


    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function register(BookRequest $bookRequest): object
    {
        $validate = $bookRequest->validated();
        return $this->bookRepository->save($validate);
    }

    public function allRecords(): object
    {
        $books = $this->bookRepository->all();
        if($books->isEmpty()){
            throw new JsonException('Não foram encontrados registros de livros!');
        }
        return $books;
    }

    public function details(int $bookId): object|null
    {
        $book = $this->bookRepository->find($bookId);
        if(!$book){
            throw new JsonException('Não foi possível buscar o livro!');
        }
        return $book;
    }

    public function detailsWithCopies(int $bookId): object|null
    {
        $book = $this->bookRepository->withCopies($bookId);
        if(!$book){
            throw new JsonException('Não foi possível buscar o livro com detalhes de emprestimos!');
        }
        return $book;
    }

    public function detailsWithAuthor(int $bookId): object|null
    {
        $book = $this->bookRepository->withAuthor($bookId);
        if(!$book){
            throw new JsonException('Não foi possível buscar o livro com detalhes do autor!');
        }
        return $book;
    }

    public function detailsWithPublisher(int $bookId): object|null
    {
        $book = $this->bookRepository->withPublisher($bookId);
        if(!$book){
            throw new JsonException('Não foi possível buscar o livro com detalhes da editora!');
        }
        return $book;
    }

    public function edit(int $bookId, BookRequest $bookRequest): bool
    {
        $validate = $bookRequest->validated();
        if(!$this->bookRepository->update($bookId, $validate)){
            throw new JsonException('Não foi possível atualizar o livro!');
        }
        return true;
    }

    public function delete(int $bookId): bool
    {
        if(!$this->bookRepository->delete($bookId)){
            throw new JsonException('Não foi possível deletar o livro!');
        }
        return true;
    }
}
