<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\AbsenMahasiswa;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AbsenController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Buat Absen',
            'absen' => Absen::where('id_user', Auth::user()->id)->get(),
        ];
        return view('pages.absen.index', $data);
    }
    public function scan()
    {
        $data = [
            'title' => 'Absen',
        ];

        return view('pages.absen.scan', $data);
    }
    public function createAbsen(Request $request)
    {
        $code_bcript = $request->code;
        $absen = Absen::where('code_absen', $code_bcript)->first();
        $now = date('d-m-Y H:i');

        if ($absen != null) {
            $expired = $absen->expired_date;
            if ($expired <= $now) {
                $jadwal = Jadwal::find($absen->id_jadwal);
                if ($jadwal != null) {
                    $Absen = new AbsenMahasiswa();
                    $Absen->id_jadwal = $jadwal->id;
                    $Absen->id_user = Auth::user()->id;
                    $Absen->save();
                    return redirect()->back()->with('success', 'Berhasil absen pada matakuliah ' . $jadwal->matakuliah->name);
                } else {
                    return redirect()->back()->with('danger', 'Jadwal tidak tersedia');
                }
            } else {
                return redirect()->back()->with('danger', 'Waktu absen telah berakhir, absen berlaku sampai : ' . $expired);
            }
        } else {
            return redirect()->back()->with('danger', 'Qr code tak dikenali');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => ['required'],
        ]);
        $Absen = new Absen();
        $Absen->id_jadwal = $request->id_jadwal;
        $Absen->expired_date = $request->expired_date;
        $Absen->longitude = $request->longitude;
        $Absen->latitude = $request->latitude;
        $Absen->code_absen = hash::make($request->id_jadwal);
        $Absen->id_user = Auth::user()->id;

        if ($Absen->save()) {
            return redirect()->back()->with('success', 'Berhasil membuat absen');
        } else {
            return redirect()->back()->with('danger', 'Gagal membuat absen');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_jadwal' => ['required'],
        ]);
        $Absen = Absen::findOrFail($id);
        $Absen->id_jadwal = $request->id_jadwal;
        $Absen->code_absen = hash::make($request->id_jadwal);
        $Absen->id_user = Auth::user()->id;

        if ($Absen->save()) {
            return redirect()->back()->with('success', 'Berhasil membuat absen');
        } else {
            return redirect()->back()->with('danger', 'Gagal membuat absen');
        }
    }
    public function destroy($id)
    {
        $Absen = Absen::find($id);
        $cek_absen_mahasiswa = AbsenMahasiswa::where('id_absen', $id);
        if ($cek_absen_mahasiswa->count() != 0) {
            $cek_absen_mahasiswa->delete();
        }
        $Absen->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus absen');
    }
}
