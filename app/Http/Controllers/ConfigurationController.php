<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengaturan Aplikasi',
            'configuration' => Configuration::Konfigurasi(),
        ];
        return view('pages.configuration.index', $data);
    }
    public function update(Request $request)
    {
        $id = 1;
        $request->validate([
            'jurusan' => ['required'],
            'kajur' => ['required'],
            'nip' => ['required'],
        ]);
        $konfigurasi = Configuration::findOrFail($id);
        $konfigurasi->jurusan = $request->jurusan;
        $konfigurasi->kajur = $request->kajur;
        $konfigurasi->nip = $request->nip;

        if ($konfigurasi->save()) {
            return redirect()->back()->with('success', 'Berhasil mengubah pengaturan');
        } else {
            return redirect()->back()->with('danger', 'Gagal mengubah pengaturan');
        }
    }
}
