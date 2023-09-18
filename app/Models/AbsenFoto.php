<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsenFoto extends Model
{
    use HasFactory;
    // protected $guarded;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function absen(): BelongsTo
    {
        return $this->belongsTo(Absen::class, 'id_absen', 'id');
    }
}
