<?php


namespace App\Repositories;

use App\Models\Book;

class BookRepository extends BaseRepository
{
    protected Book $book;

    public function __construct(Book $book)
    {
        parent::__construct($book);
        $this->book = $book;
    }

    public function withLoans(int $bookId): object|null
    {
        return $this->book::with('loans')->find($bookId);
    }

    public function withAuthor(int $bookId): object|null
    {
        return $this->book::with('author')->find($bookId);
    }

    public function withPublisher(int $bookId): object|null
    {
        return $this->book::with('publisher')->find($bookId);
    }

}
