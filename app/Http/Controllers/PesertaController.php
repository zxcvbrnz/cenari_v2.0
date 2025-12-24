<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Instruktur;
use App\Models\Peserta;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function beranda()
    {
        return view('dashboard',);
    }
    public function absen($token)
    {
        $id = Auth::user()->id_peserta;
        $ins = Peserta::where('id', $id)->value('id_instruktur');
        $qrcode = Instruktur::where('id', $ins)->value('qrcode');

        if ($token === $qrcode) {
            date_default_timezone_set('Asia/Ujung_Pandang');
            $waktu_absen = date('H:i');
            $absen = Absen::where('id_peserta', $id)->update([
                'status' => 2,
                'waktu_absen' => $waktu_absen,
            ]);
            return redirect()->back()->with('alert-success', 'Anda Telah Melakukan Absensi');
        } else {
            return redirect()->back()->with('gagal');
        }
    }

    public function absensi()
    {
        $id = Auth::user()->id_peserta;
        $data = Absen::where('id_peserta', $id)->get();
        return view('peserta.absensi');
    }

    public function penilaian()
    {
        // sertifikat dan nilai peserta
        return view('peserta.penilaian');
    }

    public function materi()
    {
        if (auth()->user()->peserta->id_group) {
            $id_mapel = auth()->user()->peserta->group->mapel->id;
        } else {
            $id_mapel = auth()->user()->peserta->id_mapel;
        }
        $materi = Materi::where('id_mapel', $id_mapel)->get();

        return view('', compact('materi'));
    }

    public function detail_materi($id)
    {
        $data = Materi::findOrFail($id);
        return view('', compact('data'));
    }

    public function pesan()
    {
        $data = Pesan::all();
        return view('', compact('data'));
    }

    public function create_pesan(Request $request)
    {
        Pesan::create([
            'id_user' => Auth()->user()->id,
            'nama' => Auth()->user()->nama,
            'isi_pesan' => $request->isi_pesan,
        ]);
    }

    public function delete_pesan($id)
    {
        Pesan::findOrFail($id)->delete();
        return redirect()->back();
    }
}
