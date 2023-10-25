<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IjinController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\rerportController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\UserController;
use App\Models\AbsenMateri;
use App\Models\Configuration;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::middleware('auto.absen.confirmation')->group(function () {
    Route::post('/storeConfirm', [AbsenController::class, 'storeConfirm']);
});
Route::middleware(['auth'])->group(function () {
    Route::put('/read_notif/{id}', [NotifikasiController::class, 'read'])->name('read_notif');
    Route::put('/read_all/{id}', [NotifikasiController::class, 'read_all'])->name('read_all');
    Route::get('/notifikasi', [HomeController::class, 'notifikasi'])->name('notifikasi');

    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/home', 'HomeController@index')->name('home');
    //semua route
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    //route jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/jadwal/show/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::get('/jadwal/exportJadwal/{id}', [JadwalController::class, 'exportJadwal'])->name('jadwal.exportJadwal');
    Route::get('/jadwal/exportJadwalMahasiswa/{id}', [JadwalController::class, 'exportJadwalMahasiswa'])->name('jadwal.exportJadwalMahasiswa');
    Route::get('/jadwal/exportJadwalAll', [JadwalController::class, 'exportJadwalAll'])->name('jadwal.exportJadwalAll');
});
// Grouping routes for admin middleware
Route::middleware(['role:admin,super_admin'])->group(function () {
    //route semester
    Route::get('/semester', [SemesterController::class, 'index'])->name('semester');
    Route::post('/semester/store', [SemesterController::class, 'store'])->name('semester.store');
    Route::put('/semester/update/{id}', [SemesterController::class, 'update'])->name('semester.update');
    Route::delete('/semester/destroy/{id}', [SemesterController::class, 'destroy'])->name('semester.destroy');
    //route class
    Route::get('/class', [ClassController::class, 'index'])->name('class');
    Route::post('/class/store', [ClassController::class, 'store'])->name('class.store');
    Route::put('/class/update/{id}', [ClassController::class, 'update'])->name('class.update');
    Route::delete('/class/destroy/{id}', [ClassController::class, 'destroy'])->name('class.destroy');
    //route ruangan
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan');
    Route::post('/ruangan/store', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::put('/ruangan/update/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/destroy/{id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
    //route ruangan
    Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('matakuliah');
    Route::post('/matakuliah/store', [MataKuliahController::class, 'store'])->name('matakuliah.store');
    Route::put('/matakuliah/update/{id}', [MataKuliahController::class, 'update'])->name('matakuliah.update');
    Route::delete('/matakuliah/destroy/{id}', [MataKuliahController::class, 'destroy'])->name('matakuliah.destroy');
    //route jadwal
    Route::get('/jadwal/input_mahasiswa/{id}', [JadwalController::class, 'input_mahasiswa'])->name('jadwal.input_mahasiswa');
    // Route::get('/jadwal', [JadwalController::class, 'admin'])->name('jadwal');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal/storeInput', [JadwalController::class, 'storeInput'])->name('jadwal.storeInput');
    Route::put('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/destroyInput/{id}', [JadwalController::class, 'destroyInput'])->name('jadwal.destroyInput');
    Route::delete('/jadwal/destroy/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    // Route::get('/jadwal/exportAbsen/{id}', [JadwalController::class, 'exportAbsen'])->name('jadwal.exportAbsen');
    // Route::get('/jadwal/exportJadwal/{id}', [JadwalController::class, 'exportJadwal'])->name('jadwal.exportJadwal');
    // Route::get('/jadwal/exportJadwalAll', [JadwalController::class, 'exportJadwalAll'])->name('jadwal.exportJadwalAll');
    // Route::post('/jadwal/show/{id}', [JadwalController::class, 'showAdmin'])->name('jadwal.showAdmin');
    //route user
    Route::get('/user/mahasiswa', [UserController::class, 'mahasiswa'])->name('user.mahasiswa');
    Route::get('/user/dosen', [UserController::class, 'dosen'])->name('user.dosen');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    //konfigurasi 
    Route::get('/konfigurasi', [ConfigurationController::class, 'index'])->name('konfigurasi');
    Route::put('/konfigurasi/update/{id}', [ConfigurationController::class, 'update'])->name('konfigurasi.update');
    // Other routes for admin...
});


// Grouping routes for mahasiswa middleware
Route::middleware(['role:mahasiswa'])->group(function () {
    //route pengajuan ijin 

    Route::post('/ijin/store', [IjinController::class, 'store'])->name('ijin.store');
    //route absen 
    Route::get('/scan', [AbsenController::class, 'scan'])->name('scan');
    Route::get('/history', [AbsenController::class, 'history'])->name('history');
    Route::post('/scan/createAbsen', [AbsenController::class, 'createAbsen'])->name('createAbsen');
    Route::post('/scan/absenMahasiswa', [AbsenController::class, 'absenMahasiswa'])->name('scan.absenMahasiswa');
});

// Grouping routes for dosen middleware
Route::middleware(['role:dosen,mahasiswa,ketua_jurusan'])->group(function () {
    Route::get('/ijin', [IjinController::class, 'index'])->name('ijin');
    Route::put('/ijin/terima/{id}', [IjinController::class, 'terima'])->name('ijin.terima');
    Route::put('/ijin/tolak/{id}', [IjinController::class, 'tolak'])->name('ijin.tolak');
});
Route::middleware(['role:dosen,ketua_jurusan'])->group(function () {
    Route::get('/absen', [AbsenController::class, 'index'])->name('absen');
    Route::get('/absen/qr/{id}', [AbsenController::class, 'qr'])->name('absen.qr');
    Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');
    Route::post('/absen/storeConfirm', [AbsenController::class, 'storeConfirm'])->name('absen.storeConfirm');
    Route::get('/absen/confirm/{id}', [AbsenController::class, 'confirm'])->name('absen.confirm');
    Route::put('/absen/update/{id}', [AbsenController::class, 'update'])->name('absen.update');
    Route::delete('/absen/destroy/{id}', [AbsenController::class, 'destroy'])->name('absen.destroy');
    //route materi pertemuan
    Route::post('/materi/storeMateri', [Absen::class, 'storeMateri'])->name('materi.storeMateri');
    Route::put('/materi/updateMateri/{id}', [Absen::class, 'updateMateri'])->name('materi.updateMateri');
});
Route::middleware(['role:dosen'])->group(function () {

    //route materi pertemuan
    Route::post('/materi/storeMateri', [Absen::class, 'storeMateri'])->name('materi.storeMateri');
    Route::put('/materi/updateMateri/{id}', [Absen::class, 'updateMateri'])->name('materi.updateMateri');
});
Route::middleware(['role:admin,super_admin,dosen,ketua_jurusan'])->group(function () {

    Route::get('/jadwal/exportAbsen/{id}', [JadwalController::class, 'exportAbsen'])->name('jadwal.exportAbsen');
});

// Grouping routes for KetuaJurusan middleware
Route::middleware(['role:ketua_jurusan,admin,super_admin'])->group(function () {
    //route report
    Route::get('/report/mahasiswa', [ReportController::class, 'mahasiswa'])->name('report.mahasiswa');
    Route::get('/report/exportMahasiswa', [ReportController::class, 'exportMahasiswa'])->name('report.exportMahasiswa');
    Route::get('/report/dosen', [ReportController::class, 'dosen'])->name('report.dosen');
    Route::get('/report/exportDosen', [ReportController::class, 'exportDosen'])->name('report.exportDosen');
});
Route::middleware(['role:ketua_jurusan,admin,super_admin,dosen'])->group(function () {
    //route report
    Route::get('/jadwal/show/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
});
