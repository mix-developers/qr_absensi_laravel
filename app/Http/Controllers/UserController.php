<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mahasiswa()
    {
        $data = [
            'title' => 'Data Mahasiswa',
            'user' => User::where('role', 'mahasiswa')->get(),
        ];
        return view('pages.user.mahasiswa', $data);
    }
    public function dosen()
    {
        $data = [
            'title' => 'Data dosen',
            'user' => User::where('role', 'dosen')->orWhere('role', 'ketua_jurusan')->orderBy('role', 'DESC')->get(),
        ];
        return view('pages.user.dosen', $data);
    }
    public function show($id)
    {
        $user = User::find($id);
        $data = [
            'title' => 'Jadwal Kuliah ' . $user->name . $user->last_name,
            'user' => $user,
            'jadwal' => Jadwal::where('id_user', $id)->get(),
        ];
        return view('pages.user.show', $data);
    }

    public function store()
    {

        return view('pages.user.show');
    }
}
