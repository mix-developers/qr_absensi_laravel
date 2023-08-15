<?php

namespace App\Http\Controllers;

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
            'user' => User::where('role', 'dosen')->get(),
        ];
        return view('pages.user.dosen', $data);
    }
}
