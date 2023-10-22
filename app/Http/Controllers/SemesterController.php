<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Semester',
            'semester' => Semester::latest()->get(),
        ];
        return view('pages.semester.index', $data);
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
            'year' => ['required'],
            'type' => ['required'],
        ]);
        $Semester = new Semester();
        $Semester->year = $request->year;
        $Semester->type = $request->type;
        $Semester->code = $request->year . $request->type;

        if ($Semester->save()) {
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
            'year' => ['required'],
            'type' => ['required'],
        ]);
        $Semester = Semester::findOrFail($id);
        $Semester->year = $request->year;
        $Semester->type = $request->type;
        $Semester->code = $request->year . $request->type;

        if ($Semester->save()) {
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
        try {
            $semester = Semester::find($id);
            $semester->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
