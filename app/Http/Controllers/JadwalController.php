<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Jadwa Kuliah',
            'jadwal' => Jadwal::all(),
        ];
        return view('pages.jadwal.index', $data);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bidang  $bidang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Jadwal = Jadwal::find($id);
        $Jadwal->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
