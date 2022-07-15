<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Copy extends Model
{
    use HasFactory;

    protected $table = 'copies';

    protected $fillable = [
        'isbn',
        'id_book',
        'status'
    ];

    public function loan(): HasOne
    {
        return $this->hasOne(Loan::class, 'id_load');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'id_book');
    }
}
