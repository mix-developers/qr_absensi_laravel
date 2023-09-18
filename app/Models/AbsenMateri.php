<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsenMateri extends Model
{
    use HasFactory;
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function absen(): BelongsTo
    {
        return $this->belongsTo(Absen::class, 'id_absen', 'id');
    }
    public static function Materi()
    {
        return self::with(['user', 'absen', 'jadwal']);
    }
    public static function getMateriAbsen($id_absen)
    {
        $materi = self::Materi()->where('id_absen', $id_absen)->first();
        return $materi != null ? $materi->materi : 'Materi tidak diisi...';
    }
}
