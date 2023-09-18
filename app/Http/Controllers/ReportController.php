<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    public function mahasiswa()
    {
        $data = [
            'title' => 'Laporan data mahasiswa',
            'user' => User::where('role', 'mahasiswa')->get(),
        ];
        return view('pages.report.mahasiswa', $data);
    }
    public function dosen()
    {
        $data = [
            'title' => 'Laporan data dosen',
            'user' => User::where('role', 'dosen')->orWhere('role', 'ketua_jurusan')->get(),
        ];
        return view('pages.report.dosen', $data);
    }

    public function exportDosen()
    {
        $data = User::where('role', 'dosen')->orWhere('role', 'ketua_jurusan')->orderBy('role', 'DESC')->get();

        $pdf =  \PDF::loadView('pages.report.pdf.pdf_dosen', [
            'data' => $data,
        ])->setPaper('a4', 'landscape')->setOption(['dpi' => 150]);

        return $pdf->stream('Dosen ' . '.pdf');
    }
    public function exportMahasiswa()
    {
        $data = User::where('role', 'mahasiswa')->orderBy('role', 'DESC')->get();

        $pdf =  \PDF::loadView('pages.report.pdf.pdf_mahasiswa', [
            'data' => $data,
        ])->setPaper('a4', 'landscape')->setOption(['dpi' => 150]);

        return $pdf->stream('Mahasiswa ' . '.pdf');
    }
}
