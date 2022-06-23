<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Editora extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ativo'
    ];

    public function livros(): HasMany
    {
        return $this->hasMany(Livro::class, 'id_editora');
    }
}
