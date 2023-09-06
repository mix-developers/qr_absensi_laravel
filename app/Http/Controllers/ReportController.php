<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function mahasiswa()
    {
        $data = [
            'title' => 'Laporan data mahasiswa',
        ];
        return view('pages.report.mahasiswa', $data);
    }
    public function dosen()
    {
        $data = [
            'title' => 'Laporan data dosen',
        ];
        return view('pages.report.dosen', $data);
    }
    public function jadwal()
    {
        $data = [
            'title' => 'Laporan data jadwal',
        ];
        return view('pages.report.jadwal', $data);
    }
}
