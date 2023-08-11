<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Mata Kuliah',
            'MataKuliah' => MataKuliah::all(),
        ];
        return view('pages.matakuliah.index', $data);
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
            'name' => ['required'],
            'sks' => ['required'],

        ]);
        $MataKuliah = new MataKuliah();
        $MataKuliah->name = $request->name;
        $MataKuliah->sks = $request->sks;


        if ($MataKuliah->save()) {
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
            'sks' => ['required'],

        ]);
        $MataKuliah = MataKuliah::findOrFail($id);
        $MataKuliah->name = $request->name;
        $MataKuliah->sks = $request->sks;


        if ($MataKuliah->save()) {
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
        $MataKuliah = MataKuliah::find($id);
        $MataKuliah->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
