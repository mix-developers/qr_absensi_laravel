<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id');
    }
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'id_class', 'id');
    }
    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'id_matakuliah', 'id');
    }
}
