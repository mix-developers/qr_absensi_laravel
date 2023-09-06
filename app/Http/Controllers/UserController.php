<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\AbsenMateri;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required'],
            'name' => ['required'],
            'last_name' => ['required'],
            'identity' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required', 'date'],
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->identity = $request->identity;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->password = Hash::make('password');

        if ($user->save()) {
            return redirect()->back()->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan data');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bidang  $bidang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'last_name' => ['required'],
            'identity' => ['required'],
            'email' => ['required'],
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->identity = $request->identity;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;

        if ($user->save()) {
            return redirect()->back()->with('success', 'Berhasil mengubah data');
        } else {
            return redirect()->back()->with('danger', 'Gagal mengubah data');
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $absen = Absen::where('id_user', $id)->get();
        $jadwal = Jadwal::where('id_user', $id)->get();
        $materi = AbsenMateri::where('id_user', $id)->get();
        if ($absen->count() != 0) {
            $absen->delete();
        }
        if ($jadwal->count() != 0) {
            $jadwal->delete();
        }
        if ($materi->count() != 0) {
            $materi->delete();
        }
        $user->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
