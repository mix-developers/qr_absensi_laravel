<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\AbsenConfirm;
use App\Models\AbsenFoto;
use App\Models\AbsenIjin;
use App\Models\AbsenMahasiswa;
use App\Models\AbsenMateri;
use App\Models\Jadwal;
use App\Models\JadwalMahasiswa;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDO;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semester = Semester::latest()->first()->code;
        if (Auth::user()->role == 'dosen' || Auth::user()->role == 'ketua_jurusan') {
            $jadwal = Jadwal::where('id_user', Auth::user()->id)->where('code', $semester)->get();
        } elseif (Auth::user()->role == 'mahasiswa') {
            $jadwal = JadwalMahasiswa::where('id_user', Auth::user()->id)
                ->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })
                ->get();
        } else {
            $jadwal = Jadwal::where('code', $semester)->get();
        }
        $data = [
            'title' => 'Data Jadwal Kuliah',
            'jadwal' => $jadwal,
        ];
        return view('pages.jadwal.index', $data);
    }
    public function jadwal_mahasiswa()
    {
        $semester = Semester::latest()->first()->code;
        $jadwal = JadwalMahasiswa::where('id_user', Auth::user()->id)
            ->whereHas('jadwal', function ($query) use ($semester) {
                $query->where('code', $semester);
            })
            ->get();
        $data = [
            'title' => ' Jadwal Kuliah',
            'jadwal' => $jadwal,
        ];
        return view('pages.jadwal.mahasiswa', $data);
    }
    public function admin()
    {
        $semester = Semester::latest()->first()->code;
        $jadwal = Jadwal::where('code', $semester)->get();

        $data = [
            'title' => 'Data Jadwa Kuliah',
            'jadwal' => $jadwal,
        ];
        return view('pages.jadwal.index', $data);
    }
    public function show($id)
    {
        try {
            $semester = Semester::latest()->first()->code;
            $jadwal = Jadwal::find($id);

            // Konfirmasi absen
            $absen_mahasiswa = AbsenMahasiswa::where('id_jadwal', $id)
                ->whereNotExists(function ($query) use ($id) {
                    $query->select(DB::raw(1))
                        ->from('absen_confirms')
                        ->whereRaw('absen_confirms.id_jadwal = absen_mahasiswas.id_jadwal')
                        ->whereRaw('absen_confirms.id_absen = absen_mahasiswas.id_absen');
                })
                ->get();

            foreach ($absen_mahasiswa as $item) {
                $confirm = new AbsenConfirm();
                $confirm->id_jadwal = $item->id_jadwal;
                $confirm->id_user = $item->id_user;
                $confirm->id_absen = $item->id_absen;
                $confirm->save();
            }

            // Hapus foto
            $absen = Absen::where('id_jadwal', $id)->get();
            foreach ($absen as $abs) {
                $foto_absen = AbsenFoto::where('id_absen', $abs->id_absen)->get();
                foreach ($foto_absen as $foto) {
                    $foto->delete();
                    Storage::delete($foto->foto);
                }
            }

            $ijin = AbsenIjin::where('id_jadwal', $id)->where('konfirmasi', 1)->get();
            $absen_latest = Absen::where('id_user', Auth::user()->id)->first();
            $data = [
                'title' => 'Data Absen Kuliah',
                'jadwal' => $jadwal,
                'ijin' => $ijin,
                'jadwal_mahasiswa' => JadwalMahasiswa::where('id_jadwal', $jadwal->id)->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })
                    ->get(),
                'absen' => $absen_latest,
                'absen_confirm' => AbsenConfirm::where('id_absen', optional($absen_latest)->id)->first(),
                'absen_mahasiswa' => AbsenConfirm::where('id_absen', optional($absen_latest)->id)->get(),
            ];
            return view('pages.jadwal.show', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show_jadwal_mahasiswa($id)
    {
        $semester = Semester::latest()->first()->code;
        $ID = Crypt::decryptString($id);
        // dd($id);
        $jadwal = Jadwal::find($ID);
        $data = [
            'title' => 'Data Absen Kuliah',
            'jadwal' => $jadwal,
            'jadwal_mahasiswa' => JadwalMahasiswa::where('id_jadwal', $jadwal->id)->whereHas('jadwal', function ($query) use ($semester) {
                $query->where('code', $semester);
            })
                ->get(),
        ];
        return view('pages.jadwal.show', $data);
    }
    public function showAdmin($id)
    {
        $semester = Semester::latest()->first()->code;
        $ID = Crypt::decryptString($id);
        // dd($id);
        $jadwal = Jadwal::find($ID);
        $data = [
            'title' => 'Data Absen Kuliah',
            'jadwal' => $jadwal,
            'jadwal_mahasiswa' => JadwalMahasiswa::where('id_jadwal', $jadwal->id)
                ->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })
                ->get(),
        ];
        return view('pages.jadwal.show', $data);
    }
    public function input_mahasiswa($id)
    {
        $semester = Semester::latest()->first()->code;
        $user = User::find($id);
        // dd($id);
        $data = [
            'title' => 'Data Input Jadwal mahasiswa : ' . $user->name,
            'user' => $user,
            'jadwal' => Jadwal::all(),
            'jadwal_mahasiswa' => JadwalMahasiswa::where('id_user', $user->id)->whereHas('jadwal', function ($query) use ($semester) {
                $query->where('code', $semester);
            })
                ->get(),
        ];
        return view('pages.jadwal.input_mahasiswa', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_user' => ['required'],
                'id_ruangan' => ['required'],
                'id_class' => ['required'],
                'id_matakuliah' => ['required'],
                'time_start' => ['required'],
                'time_end' => ['required'],
                'day' => ['required'],
            ]);
            $Jadwal = new Jadwal();
            $Jadwal->id_user = $request->id_user;
            $Jadwal->id_ruangan = $request->id_ruangan;
            $Jadwal->id_class = $request->id_class;
            $Jadwal->id_matakuliah = $request->id_matakuliah;
            $Jadwal->time_start = $request->time_start;
            $Jadwal->time_end = $request->time_end;
            $Jadwal->day = $request->day;


            if ($Jadwal->save()) {
                return redirect()->back()->with('success', 'Berhasil menambahkan data');
            } else {
                return redirect()->back()->with('danger', 'Gagal menambahkan data');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeInput(Request $request)
    {
        try {
            $request->validate([
                'id_jadwal' => ['required'],
                'id_user' => ['required'],
            ]);
            $semester = Semester::latest()->first()->code;
            $check_jadwal_mahasiswa =  JadwalMahasiswa::where('id_jadwal', $request->id_jadwal)
                ->where('id_user', $request->id_user)
                ->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })
                ->count();
            // dd($check_jadwal_mahasiswa);

            if ($check_jadwal_mahasiswa == 0) {
                $JadwalMahasiswa = new JadwalMahasiswa();
                $JadwalMahasiswa->id_jadwal = $request->id_jadwal;
                $JadwalMahasiswa->id_user = $request->id_user;
            } else {
                return redirect()->back()->with('danger', 'Matakuliah telah tersedia pada jadwal mahasiswa');
            }

            if ($JadwalMahasiswa->save()) {
                return redirect()->back()->with('success', 'Berhasil membuat jadwal');
            } else {
                return redirect()->back()->with('danger', 'Gagal membuat jadwal');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
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
        try {
            $request->validate([
                'id_user' => ['required'],
                'id_ruangan' => ['required'],
                'id_class' => ['required'],
                'id_matakuliah' => ['required'],
                'time_start' => ['required'],
                'time_end' => ['required'],
                'day' => ['required'],
            ]);
            $Jadwal = Jadwal::findOrFail($id);
            $Jadwal->id_user = $request->id_user;
            $Jadwal->id_ruangan = $request->id_ruangan;
            $Jadwal->id_class = $request->id_class;
            $Jadwal->id_matakuliah = $request->id_matakuliah;
            $Jadwal->time_start = $request->time_start;
            $Jadwal->time_end = $request->time_end;
            $Jadwal->day = $request->day;


            if ($Jadwal->save()) {
                return redirect()->back()->with('success', 'Berhasil mengubah data');
            } else {
                return redirect()->back()->with('danger', 'Gagal mengubah data');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bidang  $bidang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Jadwal = Jadwal::find($id);
            $Jadwal->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroyInput($id)
    {
        $Jadwal = JadwalMahasiswa::find($id);
        $Jadwal->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
    public function exportAbsen($id)
    {
        try {
            $semester = Semester::latest()->first()->code;
            $jadwal = Jadwal::find($id);
            $data = JadwalMahasiswa::where('id_jadwal', $id)
                ->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })
                ->get();
            $ijin = AbsenIjin::where('id_jadwal', $id)->where('konfirmasi', 1)->get();
            $materi = AbsenMateri::where('id_jadwal', $id)->get();

            $pdf =  \PDF::loadView('pages.jadwal.pdf.pdf_absen', [
                'data' => $data,
                'jadwal' => $jadwal,
                'ijin' => $ijin,
                'materi' => $materi
            ])->setPaper('a4', 'landscape')->setOption(['dpi' => 150]);

            return $pdf->stream('Data Absen ' . $jadwal->matakuliah->name  . date('d-m-Y') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function exportJadwal($id_user)
    {
        try {
            $semester = Semester::latest()->first()->code;
            $data = Jadwal::where('id_user', $id_user)
                ->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })->get();
            $user = User::find($id_user);

            $pdf =  \PDF::loadView('pages.jadwal.pdf.pdf_jadwal_user', [
                'data' => $data,
                'user' => $user,
            ])->setPaper('a4', 'landscape')->setOption(['dpi' => 150]);

            return $pdf->stream('Jadwal ' . $user->name  . date('d-m-Y') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function exportJadwalMahasiswa($id_user)
    {
        try {
            $semester = Semester::latest()->first()->code;
            $data = JadwalMahasiswa::where('id_user', $id_user)
                ->whereHas('jadwal', function ($query) use ($semester) {
                    $query->where('code', $semester);
                })->get();
            $user = User::find($id_user);

            $pdf =  \PDF::loadView('pages.jadwal.pdf.pdf_jadwal_mahasiswa', [
                'data' => $data,
                'user' => $user,
            ])->setPaper('a4', 'landscape')->setOption(['dpi' => 150]);

            return $pdf->stream('Jadwal ' . $user->name  . date('d-m-Y') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function exportJadwalAll()
    {
        try {
            $semester = Semester::latest()->first()->code;
            $data = Jadwal::whereHas('jadwal', function ($query) use ($semester) {
                $query->where('code', $semester);
            })->get();

            $pdf =  \PDF::loadView('pages.jadwal.pdf.pdf_jadwal', [
                'data' => $data,
            ])->setPaper('a4', 'landscape')->setOption(['dpi' => 150]);

            return $pdf->stream('Jadwal ' . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
