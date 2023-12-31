<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\AbsenConfirm;
use App\Models\AbsenFoto;
use App\Models\AbsenMahasiswa;
use App\Models\AbsenMateri;
use App\Models\Jadwal;
use App\Models\JadwalMahasiswa;
use App\Models\Notifikasi;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AbsenController extends Controller
{
    public function index()
    {
        $semester = Semester::latest()->first()->code;
        $data = [
            'title' => 'Buat Absen',
            'absen' => Absen::where('id_user', Auth::user()->id)
                ->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })->orderBy('id', 'desc')->get(),
        ];
        return view('pages.absen.index', $data);
    }
    public function history()
    {
        $semester = Semester::latest()->first()->code;
        $data = [
            'title' => 'History Absen',
            'history' => AbsenMahasiswa::where('id_user', Auth::user()->id)
                ->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })->get(),
        ];
        return view('pages.absen.history', $data);
    }
    public function scan()
    {
        $data = [
            'title' => 'Absen',
        ];

        return view('pages.absen.scan', $data);
    }
    public function confirm($id)
    {
        $data = [
            'title' => 'Konfirmasi Absen',
            'absen' => Absen::find($id),
            'absen_confirm' => AbsenConfirm::where('id_absen', $id)->first(),
            'absen_mahasiswa' => AbsenMahasiswa::where('id_absen', $id),
        ];
        return view('pages.absen.confirm', $data);
    }
    public function qr($id)
    {
        $absen = Absen::find($id);
        $data = [
            'title' => 'Qr code absen ',
            'absen' => $absen,
        ];
        return view('pages.absen.qr', $data);
    }
    // public function storeConfirm(Request $request)
    // {
    //     try {
    //         $confirm = new AbsenConfirm();
    //         $confirm->id_user = Auth::user()->id;
    //         $confirm->id_absen = $request->id_absen;

    //         $absen = Absen::find($request->id_absen);
    //         $jadwal = JadwalMahasiswa::where('id_jadwal', $absen->id_jadwal)->get();

    //         foreach ($jadwal as $item) {
    //             $cek_absen = AbsenMahasiswa::where('id_user', $item->id_user);
    //             if ($cek_absen) {
    //                 $notif = new Notifikasi();
    //                 $notif->id_user = $item->id_user;
    //                 $notif->content = 'Anda tidak melakukan absen pada matakuliah ' . $item->jadwal->matakuliah->name;
    //                 $notif->type = 'danger';
    //                 $notif->url = '/jadwal';
    //                 $notif->save();
    //             }
    //         }

    //         $absen_foto = AbsenFoto::where('id_absen', $request->id_absen)->get();
    //         foreach ($absen_foto as $foto) {
    //             $foto->delete();
    //             Storage::delete($foto->foto);
    //         }

    //         if ($confirm->save()) {
    //             return redirect()->back()->with('success', 'Absen Berhasil di konfirmasi');
    //         } else {
    //             return redirect()->back()->with('danger', 'Absen gagal di konfirmasi');
    //         }
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }
    public function storeConfirm(Request $request)
    {
        try {
            $absenIds = $request->input('konfirmasi');
            $idUserArray = $request->input('id_user');

            if ($absenIds && is_array($absenIds) && $idUserArray && is_array($idUserArray)) {
                foreach ($absenIds as $key => $absenId) {
                    $absen = Absen::find($absenId);

                    if ($absen) {
                        $data = [
                            'id_jadwal' => $absen->id_jadwal,
                            'id_user' => $idUserArray[$key], // Ambil id_user dari array
                            'id_absen' => $absen->id,
                        ];

                        // Hapus foto
                        $absen_foto = AbsenFoto::where('id_absen', $absen->id)->get();
                        foreach ($absen_foto as $foto) {
                            $foto->delete();
                            Storage::delete($foto->foto);
                        }

                        // Simpan data ke model AbsenConfirm
                        AbsenConfirm::create($data);
                    } else {
                        return redirect()->back()->with('danger', 'Absen tidak ditemukan');
                    }
                }
            } else {
                return redirect()->back()->with('danger', 'Data tidak valid');
            }

            return redirect()->back()->with('success', 'Absen berhasil dikonfirmasi');
        } catch (\Exception $e) {
            dd($e->getMessage()); // Tampilkan pesan kesalahan untuk debugging
            // return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function createAbsen(Request $request)
    {
        try {
            $request->validate([
                'code' => ['required'],
                'latitude' => ['required'],
                'longitude' => ['required'],
                'foto' => ['required', 'mimes:jpeg,png,jpg,gif'],
            ]);


            $code_bcript = $request->code;
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $absen = Absen::where('code_absen', $code_bcript)->first();
            $now = date('Y-m-d H:i');

            if ($absen != null) {

                if ($latitude == $absen->latitude && $longitude == $absen->longitude) {
                    $expired = $absen->expired_date;
                    if ($now < $expired) {
                        $jadwal = JadwalMahasiswa::where('id_jadwal', $absen->id_jadwal)->where('id_user', Auth::user()->id);
                        if ($jadwal != null) {

                            $absen_exist = AbsenMahasiswa::where('id_jadwal', $absen->id_jadwal)
                                ->where('id_absen', $absen->id)
                                ->where('id_user', Auth::user()->id)
                                ->count();

                            if ($absen_exist == 0) {
                                $Absen = new AbsenMahasiswa();
                                $Absen->id_jadwal = $absen->id_jadwal;
                                $Absen->id_absen = $absen->id;
                                $Absen->ip_public = file_get_contents('https://ipinfo.io/ip');
                                $Absen->id_user = Auth::user()->id;

                                $Absen->save();
                                $absen_foto = new AbsenFoto();
                                if ($request->hasFile('foto')) {
                                    $filename = Str::random(32) . '.' . $request->file('foto')->getClientOriginalExtension();
                                    $file_path = $request->file('foto')->storeAs('public/fotos', $filename);
                                }
                                $absen_foto->id_absen = $absen->id;
                                $absen_foto->id_user = Auth::user()->id;
                                $absen_foto->foto =  isset($file_path) ? $file_path : null;

                                if ($absen_foto->save()) {
                                    return redirect()->back()->with('success', 'Berhasil absen pada matakuliah ');
                                } else {
                                    return redirect()->back()->with('danger', 'Gagal absen pada matakuliah ');
                                }
                            } else {
                                return redirect()->back()->with('danger', 'Anda telah melakukan absen pada matakuliah beberapa saat lalu');
                            }
                        } else {
                            return redirect()->back()->with('danger', 'Jadwal tidak tersedia');
                        }
                    } else {
                        return redirect()->back()->with('danger', 'Waktu absen telah berakhir, absen berlaku sampai : ' . $expired);
                    }
                } else {
                    return redirect()->back()->with('danger', 'Anda berada di luar area absen');
                }
            } else {
                return redirect()->back()->with('danger', 'Qr code tak dikenali');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_jadwal' => ['required'],
            ]);

            $Absen = new Absen();
            $Absen->id_jadwal = $request->id_jadwal;
            $Absen->expired_date = $request->expired_date;
            $Absen->longitude = $request->longitude;
            $Absen->latitude = $request->latitude;
            $Absen->code_absen = Hash::make($request->id_jadwal);
            $Absen->id_user = Auth::user()->id;
            $Absen->save();

            $materi = new AbsenMateri();
            $materi->absen()->associate($Absen);
            $materi->id_jadwal = $request->id_jadwal;
            $materi->materi = $request->materi;
            $materi->id_user = Auth::user()->id;

            if ($materi->save()) {
                return redirect()->back()->with('success', 'Berhasil membuat absen');
            } else {
                return redirect()->back()->with('danger', 'Gagal membuat absen');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeMeteri(Request $request)
    {
        $request->validate([
            'id_jadwal' => ['required'],
            'id_absen' => ['required'],
            'materi' => ['required'],
        ]);
        $materi = new AbsenMateri();
        $materi->id_jadwal = $request->id_jadwal;
        $materi->id_absen = $request->id_absen;
        $materi->materi = $request->materi;
        $materi->id_user = Auth::user()->id;

        if ($materi->save()) {
            return redirect()->back()->with('success', 'Berhasil menambah materi');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambah materi');
        }
    }
    public function updateMeteri(Request $request, $id)
    {
        $request->validate([
            'id_jadwal' => ['required'],
            'id_absen' => ['required'],
            'materi' => ['required'],
        ]);
        $materi = AbsenMateri::find($id);

        $materi->id_jadwal = $request->id_jadwal;
        $materi->id_absen = $request->id_absen;
        $materi->materi = $request->materi;

        if ($materi->save()) {
            return redirect()->back()->with('success', 'Berhasil mengubah materi');
        } else {
            return redirect()->back()->with('danger', 'Gagal mengubah materi');
        }
    }
    public function update(Request $request, $id)
    {
        try {
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
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $absen = Absen::findOrFail($id);

            // Hapus entitas terkait
            AbsenMahasiswa::where('id_absen', $id)->delete();
            AbsenMateri::where('id_absen', $id)->delete();

            // Hapus Absen
            $absen->delete();

            return redirect()->back()->with('success', 'Berhasil menghapus absen');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Gagal menghapus absen: ' . $e->getMessage());
        }
    }
}
