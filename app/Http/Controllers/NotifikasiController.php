<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function read($id)
    {
        try {
            $notif = Notifikasi::findOrFail($id);
            $notif->read_at = Carbon::now();
            $notif->save();
            return redirect($notif->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function read_all($id)
    {
        try {
            $notif = Notifikasi::where('id_user', $id)->where('read_at', null);
            $notif->read_at = Carbon::now();
            $notif->save();
            return redirect()->back()->with('success', 'Notifikasi telah di baca semua');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
