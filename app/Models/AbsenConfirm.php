<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsenConfirm extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_jadwal',
        'id_user',
        'id_absen',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function absen(): BelongsTo
    {
        return $this->belongsTo(Absen::class, 'id_absen', 'id');
    }
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'id_absen', 'id');
    }
    // Count the number of attendances for a specific user and jadwal
    public static function getCountAbsen($id_user, $id_jadwal)
    {
        return self::with(['user', 'jadwal'])->where('id_user', $id_user)->where('id_jadwal', $id_jadwal);
    }
    public static function checkAbsen($id_absen, $id_user)
    {
        $exist = self::with(['user', 'jadwal'])->where('id_absen', $id_absen)->where('id_user', $id_user);
        return $exist;
    }
    public static function getKehadiran($id_user, $id_jadwal)
    {
        $kehadiran = self::where('id_user', $id_user)->where('id_jadwal', $id_jadwal)->count();

        return $kehadiran;
    }
    public static function getTotalAbsen($id_user, $id_jadwal)
    {
        $absen = Absen::where('id_jadwal', $id_jadwal)->count();
        return $absen;
    }
    public static function getKehadiranTotal($id_user, $id_jadwal)
    {

        return self::getKehadiran($id_user, $id_jadwal) . '/' . Self::getTotalAbsen($id_user, $id_jadwal) . ' Absen';
    }
}
