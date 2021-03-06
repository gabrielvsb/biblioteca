<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'name',
        'description',
        'release_date',
        'id_publisher',
        'active',
        'id_author'
    ];

    public function publisher(): belongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function author(): belongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function copies(): hasMany
    {
        return $this->hasMany(Copy::class, 'id_book');
    }
}
