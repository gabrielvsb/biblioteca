<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_livro',
        'data_inicio',
        'data_fim',
        'ativo'
    ];

    public function usuario(){
        return $this->hasOne(User::class);
    }

    public function livro(){
        return $this->hasOne(Livro::class);
    }
}
