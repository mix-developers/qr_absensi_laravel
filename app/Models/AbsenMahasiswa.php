<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsenMahasiswa extends Model
{
    use HasFactory;

    // Define the "user" relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Define the "jadwal" relationship
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id');
    }

    // Retrieve attendance data with related user and jadwal
    public static function getJadwal($id_jadwal)
    {
        return self::with(['user', 'jadwal'])->where('id_jadwal', $id_jadwal)->get();
    }

    // Retrieve attendance data for a specific user with related user and jadwal
    public static function getUser($id_user)
    {
        return self::with(['user', 'jadwal'])->where('id_user', $id_user)->get();
    }

    // Count the number of attendances for a specific user and jadwal
    public static function getCountAbsen($id_user, $id_jadwal)
    {
        return self::with(['user', 'jadwal'])->where('id_user', $id_user)->where('id_jadwal', $id_jadwal)->count();
    }
}
