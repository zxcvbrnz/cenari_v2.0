<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Peserta;
use App\Models\Absen;
use App\Models\Group;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Pesan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\InstrukturMapel;

use Silvanix\Wablas\Message;

use Illuminate\Support\Facades\Auth;


class InstrukturController extends Controller
{
    public function teswa()
    {
        $send = new Message();

        $payload = [
            [
                'phone' => '089691884833',
                'message' => 'Halo ' . '*Udin*' . '<br>' .
                    'Pendaftaranmu Telah Terverifikasi, Berikut Username Dan Passwordmu' .
                    '<br>' . 'Username : ' . 'username' .
                    '<br>' . 'Password : cenarikursus' .
                    '<br>' . 'Tutorial untuk menggunakan aplikasi kursus.cenari.sch.id silahkan kunjungi web http://cenari.sch.id/modul-tutorial',
            ],
            [
                'phone' => '089691884833',
                'message' => 'Halo Muhammmad' . '<br>' . 'Murid Bernama ' . '*Udin*' .
                    ' Telah Menjadi Murid Didik Anda, Untuk Lebih Lanjut' . "<br>" .
                    'Silahkan Buka www.kursus.cenari.sch.id' . "<br>" .
                    'Tutorial untuk menggunakan aplikasi kursus.cenari.sch.id silahkan kunjungi web http://cenari.sch.id/modul-tutorial',
            ],
            [
                'phone' => '089691884833',
                'message' => 'Halo Admin' . '<br>' . 'Peserta Bernama ' . 'Udin' .
                    ' Telah Didaftarkan Pada Aplikasi Dengan Akun Seperti Berikut' .
                    '<br>' . 'Username : ' . 'pass' .
                    '<br>' . 'Password : cenarikursus' .
                    '<br>' . 'Untuk Lebih Lanjut' .
                    "<br>" . 'Silahkan Buka www.kursus.cenari.sch.id' . "<br>" .
                    'Tutorial untuk menggunakan aplikasi kursus.cenari.sch.id silahkan kunjungi web http://cenari.sch.id/modul-tutorial',
            ],

        ];
        $send_text = $send->multiple_text($payload);
        return dd($send_text);
    }
    public function beranda()
    {
        $id = auth()->user()->id_instruktur;
        $permohonan = Absen::where('id_instruktur', $id)->where('status', 0)->latest()->get();
        $jadwal = Absen::where('id_instruktur', $id)->where('status', 1)->latest()->get();
        $tolak = Absen::where('id_instruktur', $id)->where('status', 3)->latest()->get();
        $peserta = Peserta::where('id_instruktur', $id)->where('status', 'aktif')->count();
        $mapel = InstrukturMapel::where('id_instruktur', $id)->count();
        $qrcode = QrCode::size(250)->generate(auth()->user()->instruktur['qrcode']);

        return view('dashboard', compact([
            'permohonan',
            'jadwal',
            'tolak',
            'peserta',
            'mapel',
            'qrcode',
        ]));
    }

    public function permohonan()
    {
        $id = Auth::user()->id;
        $data = Peserta::where('id_instruktur', $id)->get();
        $group = Group::where('id_instruktur', $id)->get();
        return view('', compact('data', 'group'));
    }


    public function sendMessage()
    {
        $send = new Message();

        $payload = [
            [
                'phone' => '089691884833',
                'message' => 'Test Pesan 1',
            ],
            [
                'phone' => '089635572871',
                'message' => 'Test Pesan 1',
            ],

        ];
        $send_text = $send->multiple_text($payload);
        return dd($send_text);
        // [
        //     'phone' => '6281229889541',
        //     'message' => 'Hello {name} Pesan with spintax',
        //     'spintax' => true,
        //     'source' => 'for personal'
        // ],
        // [
        //     'phone' => '6285867765107',
        //     'message' => 'Hello Pesan 3',
        //     'secret' => true,
        // ],
        // [
        //     'phone' => '6287817274185-1632192971',
        //     'message' => 'Test Group',
        //     'isGroup' => true,
        //     'source' => 'group personal'
        // ],
    }

    // ========= CRUD =========
    public function materi()
    {
        $id = auth()->user()->id;
        $id_mapel = InstrukturMapel::where('id_instruktur', $id)->value('id_mapel');
        $data = Materi::where('id_mapel', $id_mapel)
            ->get();

        return view('', compact($data));
    }
    public function create_materi()
    {
        $id = Auth()->user()->id;
        $mapel = InstrukturMapel::where('id_instruktur', $id)->get(); //tambahkan eloquent...
        return view('', compact('mapel'));
    }
    public function creating_materi(Request $request)
    {
        $file = $request->file('file');

        $file_path = $file->storeAs('public/files');

        Materi::create([
            'id_instruktur' => auth()->user()->id,
            'id_mapel' => $request->id_mapel,
            'judul' => $request->judul,
            'artikel' => $request->judul,
            'file' => $file_path,
            'link' => $request->link,
        ]);
    }

    public function edit_materi($id)
    {
        $data = Materi::findOrFail($id);
        return view('', compact($data));
    }
    public function update_materi(Request $request, Materi $materi)
    {
        $file = $request->file('file');

        if ($file) {
            $file_path = $file->storeAs('public/files');

            if ($materi->file) {
                Storage::delete($materi->file);
            }

            $materi->file = $file_path;
        }

        $materi->id_mapel = $request->id_mapel;
        $materi->judul = $request->judul;
        $materi->artikel = $request->judul;
        $materi->link = $request->link;

        $materi->save();

        return redirect()->back();
    }
    public function delete_materi($id)
    {
        $materi = Materi::findOrFail($id);

        if ($materi->file) {
            Storage::delete($materi->file);
        }
        $materi->delete();

        return redirect()->back();
    }

    public function detail_materi($id)
    {
        $data = Materi::findOrFail($id);
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
