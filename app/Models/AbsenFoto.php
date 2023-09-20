<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
    public static function getFoto($id_absen, $id_user)
    {
        $foto = self::with(['user', 'absen'])->where('id_absen', $id_absen)->where('id_user', $id_user)->first();
        return $foto != null ? Storage::url($foto->foto) : asset('img/no-image.jpg');
    }
}
