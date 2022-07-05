<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function editora(): belongsTo
    {
        return $this->belongsTo(Editora::class);
    }

    public function autor(): belongsTo
    {
        return $this->belongsTo(Autor::class);
    }

    public function emprestimos(): hasMany
    {
        return $this->hasMany(Emprestimo::class, 'id_livro');
    }
}
