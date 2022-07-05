<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function usuario(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function livro(): belongsTo
    {
        return $this->belongsTo(Livro::class, 'id_livro');
    }
}
