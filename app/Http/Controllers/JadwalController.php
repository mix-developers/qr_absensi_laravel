<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\AbsenConfirm;
use App\Models\AbsenIjin;
use App\Models\AbsenMahasiswa;
use App\Models\AbsenMateri;
use App\Models\Jadwal;
use App\Models\JadwalMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Crypt;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'dosen' || Auth::user()->role == 'ketua_jurusan') {
            $jadwal = Jadwal::where('id_user', Auth::user()->id)->get();
        } elseif (Auth::user()->role == 'mahasiswa') {
            $jadwal = JadwalMahasiswa::where('id_user', Auth::user()->id)->get();
        } else {
            $jadwal = Jadwal::all();
        }
        $data = [
            'title' => 'Data Jadwal Kuliah',
            'jadwal' => $jadwal,
        ];
        return view('pages.jadwal.index', $data);
    }
    public function jadwal_mahasiswa()
    {
        $jadwal = JadwalMahasiswa::where('id_user', Auth::user()->id)->get();
        $data = [
            'title' => ' Jadwal Kuliah',
            'jadwal' => $jadwal,
        ];
        return view('pages.jadwal.mahasiswa', $data);
    }
    public function admin()
    {

        $jadwal = Jadwal::all();

        $data = [
            'title' => 'Data Jadwa Kuliah',
            'jadwal' => $jadwal,
        ];
        return view('pages.jadwal.index', $data);
    }
    public function show($id)
    {
        try {
            $ID = Crypt::decryptString($id);
            // dd($id);
            $jadwal = Jadwal::find($ID);
            $ijin = AbsenIjin::where('id_jadwal', $ID)->where('konfirmasi', 1)->get();
            $absen_latest = Absen::where('id_user', Auth::user()->id)->first();
            $data = [
                'title' => 'Data Absen Kuliah',
                'jadwal' => $jadwal,
                'ijin' => $ijin,
                'jadwal_mahasiswa' => JadwalMahasiswa::where('id_jadwal', $jadwal->id)->get(),
                //konfirmasi absen otomatis
                'absen' => $absen_latest,
                'absen_confirm' => AbsenConfirm::where('id_absen', $absen_latest->id)->first(),
                'absen_mahasiswa' => AbsenMahasiswa::where('id_absen', $absen_latest->id),
            ];
            return view('pages.jadwal.show', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function show_jadwal_mahasiswa($id)
    {
        $ID = Crypt::decryptString($id);
        // dd($id);
        $jadwal = Jadwal::find($ID);
        $data = [
            'title' => 'Data Absen Kuliah',
            'jadwal' => $jadwal,
            'jadwal_mahasiswa' => JadwalMahasiswa::where('id_jadwal', $jadwal->id)->get(),
        ];
        return view('pages.jadwal.show', $data);
    }
    public function showAdmin($id)
    {
        $ID = Crypt::decryptString($id);
        // dd($id);
        $jadwal = Jadwal::find($ID);
        $data = [
            'title' => 'Data Absen Kuliah',
            'jadwal' => $jadwal,
            'jadwal_mahasiswa' => JadwalMahasiswa::where('id_jadwal', $jadwal->id)->get(),
        ];
        return view('pages.jadwal.show', $data);
    }
    public function input_mahasiswa($id)
    {
        $user = User::find($id);
        // dd($id);
        $data = [
            'title' => 'Data Input Jadwal mahasiswa : ' . $user->name,
            'user' => $user,
            'jadwal' => Jadwal::all(),
            'jadwal_mahasiswa' => JadwalMahasiswa::where('id_user', $user->id)->get(),
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
            $JadwalMahasiswa = new JadwalMahasiswa();
            $JadwalMahasiswa->id_jadwal = $request->id_jadwal;
            $JadwalMahasiswa->id_user = $request->id_user;

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
            $jadwal = Jadwal::find($id);
            $data = JadwalMahasiswa::where('id_jadwal', $id)->get();
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
            $data = Jadwal::where('id_user', $id_user)->get();
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
    public function exportJadwalAll()
    {
        try {
            $data = Jadwal::all();

            $pdf =  \PDF::loadView('pages.jadwal.pdf.pdf_jadwal', [
                'data' => $data,
            ])->setPaper('a4', 'landscape')->setOption(['dpi' => 150]);

            return $pdf->stream('Jadwal ' . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
