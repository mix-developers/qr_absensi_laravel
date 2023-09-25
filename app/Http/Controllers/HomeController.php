<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\Notifikasi;
use App\Models\Ruangan;
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

        $widget = [
            'users' => $users,
            'matakuliah' => $matakuliah,
            'kelas' => $kelas,
            'ruangan' => $ruangan,
        ];
        $data = [
            'title' => 'Dashboard',
            'widget' => $widget,
            'jadwal' => Jadwal::all(),
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
