<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Models\Configuration;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

// Grouping routes for admin middleware
Route::middleware(['admin'])->group(function () {
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
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
    Route::get('/jadwal_admin', [JadwalController::class, 'admin'])->name('jadwal_admin');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal/storeInput', [JadwalController::class, 'storeInput'])->name('jadwal.storeInput');
    Route::put('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/destroyInput/{id}', [JadwalController::class, 'destroyInput'])->name('jadwal.destroyInput');
    Route::delete('/jadwal/destroy/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::get('/jadwal/exportAbsen/{id}', [JadwalController::class, 'exportAbsen'])->name('jadwal.exportAbsen');
    Route::get('/jadwal/exportJadwal/{id}', [JadwalController::class, 'exportJadwal'])->name('jadwal.exportJadwal');
    Route::get('/jadwal/exportJadwalAll', [JadwalController::class, 'exportJadwalAll'])->name('jadwal.exportJadwalAll');
    Route::get('/jadwal/showAdmin/{id}', [JadwalController::class, 'showAdmin'])->name('jadwal.showAdmin');
    //route user
    Route::get('/user/mahasiswa', [UserController::class, 'mahasiswa'])->name('user.mahasiswa');
    Route::get('/user/dosen', [UserController::class, 'dosen'])->name('user.dosen');
    Route::get('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('user.show');
    //konfigurasi 
    Route::get('/konfigurasi', [ConfigurationController::class, 'index'])->name('konfigurasi');
    Route::put('/konfigurasi/update/{id}', [ConfigurationController::class, 'update'])->name('konfigurasi.update');


    // Other routes for admin...
});

// Grouping routes for mahasiswa middleware
Route::prefix('mahasiswa')->middleware(['mahasiswa'])->group(function () {
    Route::get('/scan', [AbsenController::class, 'scan'])->name('scan');
    Route::post('/scan/createAbsen', [AbsenController::class, 'createAbsen'])->name('createAbsen');
    Route::post('/scan/absenMahasiswa', [AbsenController::class, 'absenMahasiswa'])->name('scan.absenMahasiswa');
});

// Grouping routes for dosen middleware
Route::middleware(['dosen'])->group(function () {
    //route jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/jadwal/show/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
    //route absen
    Route::get('/absen', [AbsenController::class, 'index'])->name('absen');
    Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');
    Route::put('/absen/update/{id}', [AbsenController::class, 'update'])->name('absen.update');
    Route::delete('/absen/destroy/{id}', [AbsenController::class, 'destroy'])->name('absen.destroy');
    //route profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
});

// Grouping routes for KetuaJurusan middleware
Route::middleware(['KetuaJurusan'])->group(function () {
    // Define routes for KetuaJurusan...
});
