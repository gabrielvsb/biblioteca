<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_copy',
        'date_start',
        'date_end',
        'active'
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function copy(): belongsTo
    {
        return $this->belongsTo(Copy::class, 'id_copy');
    }
}
