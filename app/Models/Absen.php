<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absen extends Model
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
    public function AbsenMateri()
    {
        return $this->hasMany(AbsenMateri::class, 'id_absen');
    }
    public function AbsenFoto()
    {
        return $this->hasMany(AbsenFoto::class, 'id_absen');
    }
    public function AbsenConfirm()
    {
        return $this->hasMany(AbsenConfirm::class, 'id_absen');
    }
    public static function getPertemuan($id_jadwal)
    {
        $absen = self::where('id_jadwal', $id_jadwal)->count();
        $pertemuan = 16;
        return '<b>' . $absen . '</b>/' . $pertemuan . ' Pertemuan';
    }
}
