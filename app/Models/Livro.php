<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'data_lancamento',
        'id_editora',
        'quantidade_total',
        'ativo',
        'id_autor'
    ];

    public function editora(): HasOne
    {
        return $this->hasOne(Editora::class);
    }

    public function autor(): HasOne
    {
        return $this->hasOne(Autor::class);
    }
}
