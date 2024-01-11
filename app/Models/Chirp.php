<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
    ];


        // Realcion muchos a Uno -> Muchos Chirps pertenecen a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
