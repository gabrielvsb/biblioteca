<?php

namespace App\Repositories;


use App\Models\Publisher;

class PublisherRepository extends BaseRepository
{
    protected Publisher $publisher;

    public function __construct(Publisher $publisher)
    {
        parent::__construct($publisher);
        $this->publisher = $publisher;
    }

    public function withBooks(int $publisherId): object|null
    {
        return $this->publisher::with('books')->find($publisherId);
    }
}
