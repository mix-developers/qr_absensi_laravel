<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::group(['middleware' => ['admin']], function () {
    //kelas
    Route::get('/class', [ClassController::class, 'index'])->name('class');
    Route::post('/class/store', [ClassController::class, 'store'])->name('class.store');
    Route::put('/class/update/{id}', [ClassController::class, 'update'])->name('class.update');
    Route::delete('/class/destroy/{id}', [ClassController::class, 'destroy'])->name('class.destroy');
    //ruangan
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan');
    Route::post('/ruangan/store', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::put('/ruangan/update/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/destroy/{id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
    //matakuliah
    Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('matakuliah');
    Route::post('/matakuliah/store', [MataKuliahController::class, 'store'])->name('matakuliah.store');
    Route::put('/matakuliah/update/{id}', [MataKuliahController::class, 'update'])->name('matakuliah.update');
    Route::delete('/matakuliah/destroy/{id}', [MataKuliahController::class, 'destroy'])->name('matakuliah.destroy');
    //jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/destroy/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    //absen
    Route::get('/scan', [AbsenController::class, 'scan'])->name('scan');
    Route::post('/scan/createAbsen', [AbsenController::class, 'createAbsen'])->name('createAbsen');
    Route::post('/scan/absenMahasiswa', [AbsenController::class, 'absenMahasiswa'])->name('scan.absenMahasiswa');
    Route::get('/absen', [AbsenController::class, 'index'])->name('absen');
    Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');
    Route::put('/absen/update/{id}', [AbsenController::class, 'update'])->name('absen.update');
    Route::delete('/absen/destroy/{id}', [AbsenController::class, 'destroy'])->name('absen.destroy');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
Route::group(['middleware' => ['mahasiswa']], function () {

    //absen
    Route::get('/scan', [AbsenController::class, 'scan'])->name('scan');
    Route::post('/scan/createAbsen', [AbsenController::class, 'createAbsen'])->name('createAbsen');
    Route::post('/scan/absenMahasiswa', [AbsenController::class, 'absenMahasiswa'])->name('scan.absenMahasiswa');
});
Route::group(['middleware' => ['dosen']], function () {

    //absen
    Route::get('/absen', [AbsenController::class, 'index'])->name('absen');
    Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');
    Route::put('/absen/update/{id}', [AbsenController::class, 'update'])->name('absen.update');
    Route::delete('/absen/destroy/{id}', [AbsenController::class, 'destroy'])->name('absen.destroy');
});
Route::group(['middleware' => ['KetuaJurusan']], function () {
});
