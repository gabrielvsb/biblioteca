<?php

namespace App\Repositories;

use App\Models\Author;
use App\Models\Publisher;

class AuthorRepository extends BaseRepository
{
    protected Author $author;

    public function __construct(Author $author)
    {
        parent::__construct($author);
        $this->author = $author;
    }

}
