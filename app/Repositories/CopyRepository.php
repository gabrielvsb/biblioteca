<?php

namespace App\Repositories;

use App\Models\Copy;

class CopyRepository extends BaseRepository
{
    protected Copy $copy;

    public function __construct(Copy $copy)
    {
        parent::__construct($copy);
        $this->copy = $copy;
    }

}
