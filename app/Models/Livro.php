<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'data_lancamento',
        'id_editora',
        'quantidade_total',
        'ativo'
    ];

    public function editora(){
        return $this->hasOne(Editora::class);
    }

    public function emprestimos(){
        return $this->hasMany(Emprestimo::class);
    }
}
