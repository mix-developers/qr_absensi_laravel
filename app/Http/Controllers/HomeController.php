<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Jadwal;
use App\Models\JadwalMahasiswa;
use App\Models\MataKuliah;
use App\Models\Notifikasi;
use App\Models\Ruangan;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $kelas = Classes::count();
        $ruangan = Ruangan::count();
        $matakuliah = MataKuliah::count();

        $semester = Semester::latest()->first()->code;
        $jadwal_mahasiswa = JadwalMahasiswa::where('id_user', Auth::user()->id)
            ->whereHas('jadwal', function ($query) use ($semester) {
                $query->where('code', $semester);
            })
            ->get();

        $widget = [
            'users' => $users,
            'matakuliah' => $matakuliah,
            'kelas' => $kelas,
            'ruangan' => $ruangan,
        ];
        $data = [
            'title' => 'Dashboard',
            'widget' => $widget,
            'jadwal' => Jadwal::where('code', $semester)->get(),
            'jadwal_mahasiswa' => $jadwal_mahasiswa,
        ];

        return view('pages.home', $data);
    }
    public function profile()
    {
        $data = [
            'title' => 'Profile',
        ];

        return view('pages.akun.index', $data);
    }
    public function notifikasi()
    {
        $data = [
            'title' => 'Semua notifikasi',
            'notifikasi' => Notifikasi::where('id_user', Auth::user()->id)->orderBy('id', 'DESC')->get(),
        ];
        return view('pages.notifikasi', $data);
    }
}
