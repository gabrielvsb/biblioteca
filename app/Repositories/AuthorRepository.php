<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository extends BaseRepository
{
    protected Author $author;

    public function __construct(Author $author)
    {
        parent::__construct($author);
        $this->author = $author;
    }

}
