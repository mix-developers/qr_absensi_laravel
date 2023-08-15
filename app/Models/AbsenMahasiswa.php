<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsenMahasiswa extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id');
    }
    public static function getJadwal($id_jadwal)
    {
        return self::with(['user', 'jadwal'])->where('id_jadwal', $id_jadwal)->get();
    }
    public static function getUser($id_user)
    {
        return self::with(['user', 'jadwal'])->where('id_user', $id_user)->get();
    }
    public static function getCountAbsen($id_user, $id_jadwal)
    {
        return self::with(['user', 'jadwal'])->where('id_user', $id_user)->where('id_jadwal', $id_jadwal)->count();
    }
}
