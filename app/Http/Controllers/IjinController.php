<?php

namespace App\Http\Controllers;

use App\Models\AbsenFoto;
use App\Models\AbsenIjin;
use App\Models\Jadwal;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IjinController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'mahasiswa') {
            $ijin = AbsenIjin::where('id_user', Auth::user()->id)->latest()->get();
        } else {
            $jadwal = Jadwal::where('id_user', Auth::user()->id)->get();

            $jadwalIds = $jadwal->pluck('id')->toArray();

            $ijin = AbsenIjin::whereIn('id_jadwal', $jadwalIds)->latest()->get();
        }
        $data = [
            'title' => 'Pengajuan Ijin dan Sakit',
            'absen_ijin' => $ijin,
        ];
        return view('pages.ijin.index', $data);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'keterangan' => ['required'],
                'tanggal' => ['required'],
                'foto' => ['required', 'mimes:jpeg,png,jpg,gif'],
                'latitude' => ['required'],
                'longitude' => ['required'],
                'id_jadwal' => ['required'],
                'jenis' => ['required'],
            ]);
            $AbsenIjin = new AbsenIjin();
            $AbsenIjin->id_user = Auth::user()->id;
            $AbsenIjin->id_jadwal = $request->id_jadwal;
            $AbsenIjin->latitude = $request->latitude;
            $AbsenIjin->longitude = $request->longitude;
            $AbsenIjin->tanggal = $request->tanggal;
            $AbsenIjin->keterangan = $request->keterangan;
            $AbsenIjin->jenis = $request->jenis;
            if ($request->hasFile('foto')) {
                $filename = Str::random(32) . '.' . $request->file('foto')->getClientOriginalExtension();
                $file_path = $request->file('foto')->storeAs('public/fotos', $filename);
            }
            $AbsenIjin->foto =  isset($file_path) ? $file_path : null;

            $check_jadwal = Jadwal::findOrFail($AbsenIjin->id_jadwal)->first();

            if ($check_jadwal == null) {
                return redirect()->back()->with('danger', 'Gagal mendapatkan id absen');
            }
            // dd($check_jadwal->id_user);
            $notif = new Notifikasi();
            $notif->id_user = $check_jadwal->id_user;
            $notif->content = 'Pengajuan ijin pada matakuliah ' . $AbsenIjin->jadwal->matakuliah->name;
            $notif->type = 'success';
            $notif->url = '/ijin';
            if ($notif->save()) {
                if ($AbsenIjin->save()) {
                    return redirect()->back()->with('success', 'Berhasil mengajukan ijin');
                } else {
                    return redirect()->back()->with('danger', 'Gagal mengajukan ijin');
                }
            } else {
                return redirect()->back()->with('danger', 'Gagal mengirim notifikasi');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function terima(Request $request, $id)
    {
        try {
            $ijin = AbsenIjin::findOrFail($id);
            $ijin->konfirmasi = 1;
            $ijin->save();

            $notif = new Notifikasi();
            $notif->id_user = $ijin->id_user;
            $notif->content = 'Pengajuan ijin anda pada matakuliah ' . $ijin->jadwal->matakuliah->name . ' diterima';
            $notif->type = 'success';
            $notif->url = '/ijin';
            $notif->save();

            return redirect()->back()->with('success', 'Ijin berhasili disetujui');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function tolak(Request $request, $id)
    {
        try {
            $ijin = AbsenIjin::findOrFail($id);
            $ijin->konfirmasi = 2;
            $ijin->message = $request->message;
            $ijin->save();

            $notif = new Notifikasi();
            $notif->id_user = $ijin->id_user;
            $notif->content = 'Pengajuan ijin anda pada matakuliah ' . $ijin->jadwal->matakuliah->name . ' ditolak dengan alasan : ' . $request->message;
            $notif->type = 'danger';
            $notif->url = '/ijin';
            $notif->save();

            return redirect()->back()->with('success', 'Ijin berhasili ditolak');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
