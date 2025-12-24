<?php

namespace App\Http\Controllers;

use App\Exports\PembayaranExport;
use App\Exports\PesertaExport;
use App\Models\Pembayaran;
use App\Models\Sertifikat;
use Illuminate\Auth\Events\Registered;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Pesan;
use App\Models\Instruktur;
use App\Models\Mapel;
use App\Models\InstrukturMapel;
use App\Models\Absen;
use App\Models\Group;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Silvanix\Wablas\Message;

class AdminController extends Controller
{

    public function a()
    {
        return dd('admin');
    }
    public function beranda()
    {
        $private_baru = Peserta::where('status', 'aktif')->count();
        $private_lulus = Peserta::where('status', 'nonaktif')->count();
        $pelatihan_baru = Peserta::where('status', 'aktif')->where('id_group', '!=', null)->count();
        $pelatihan_lulus = Peserta::where('status', 'nonaktif')->where('id_group', '!=', null)->count();
        $data = [
            'labels' => ['Murid Private Daftar', 'Murid Private Lulus', 'Murid Pelatihan Daftar', 'Murid Pelatihan Lulus'],
            'data' => [$private_baru, $private_lulus, $pelatihan_baru, $pelatihan_lulus],
        ];
        return view('dashboard', compact('data'))
            ->with('peserta', $private_baru)
            ->with('instruktur', $private_lulus)
            ->with('mapel', $pelatihan_baru)
            ->with('pelatihan', $pelatihan_lulus);
    }


    // ========= CRUD PESERTA ==========
    public function unique_code_peserta($unique_code)
    {
        $peserta = Peserta::with('user')->where('unique_code', $unique_code)->firstOrFail();

        return view('welcome', compact('peserta'));
    }

    public function peserta()
    {
        return view('admin.data-peserta');
    }

    public function create_peserta()
    {
        // $ins = Instruktur::all();
        $ins = InstrukturMapel::all();
        $mapels = Mapel::all();
        $groups = Group::where('status', 'aktif')->get();
        return view('admin.create-peserta', compact('ins', 'mapels', 'groups'));
    }
    public function creating_peserta(Request $request)
    {
        $str = Str::random(30) . Carbon::now()->getTimestamp() . Str::random(30);
        $id_instruktur = null;
        $id_mapel = null;
        if ($request->instruktur) {
            $insmap = explode('-', $request->instruktur);
            $id_instruktur = $insmap[0];
            $id_mapel = $insmap[1];
        }
        $status_pembayaran = $request->status_pembayaran;
        if ($request->id_group) {
            $status_pembayaran = 'Lunas';
        }
        $data = Peserta::create([
            'id_instruktur' => $id_instruktur,
            'id_group' => $request->id_group,
            'id_mapel' => $id_mapel,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'nisn' => $request->nisn,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pendidikan' => $request->pendidikan,
            'agama' => $request->agama,
            'kewarganegaraan' => $request->kewarganegaraan,
            'penerima_kps' => $request->penerima_kps,
            'no_kps' => $request->no_kps,
            'layak_pip' => $request->layak_pip,
            'alasan_pip' => $request->alasan_pip,
            'penerima_kip' => $request->penerima_kip,
            'no_kip' => $request->no_kip,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kode_pos' => $request->kode_pos,
            'nama_desa_kelurahan' => $request->nama_desa_kelurahan,
            'provinsi' => $request->provinsi,
            'kab_kota' => $request->kab_kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'jenis_tinggal' => $request->jenis_tinggal,
            'alat_transportasi' => $request->alat_transportasi,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'status_saat_ini' => $request->status_saat_ini,
            'status' => 'aktif',
            'status_pembayaran' => $status_pembayaran,
            'barcode' => $str,
        ]);
        Sertifikat::create(['id_peserta' => $data->id]);
        if (!$request->id_group) {
            Pembayaran::create([
                'id_peserta' => $data->id,
                'jumlah_dibayar' => $request->jumlah_dibayar,
                'tanggal_dibayar' => $request->tanggal_dibayar,
                'deskripsi' => $request->deskripsi,
            ]);
        }
        $username = '';
        $nameParts = explode(' ', $request->name);
        if (count($nameParts) > 0) {
            $firstName = $nameParts[0];
            $secondName = count($nameParts) > 1 ? $nameParts[1] : '';
            $nameToUse = $secondName ?: $firstName;
            $username = Str::of($nameToUse . ' ' . $data->id)->slug('-');
        }
        $akun = [
            'name' => $request->name,
            'role' => 'peserta',
            'id_peserta' => $data->id,
            'username' => $username,
            'password' => 'cenarikursus'
        ];
        $akun['password'] = Hash::make($akun['password']);
        event(new Registered((User::create($akun))));

        $send = new Message();

        $nomor_ins = $data->id_group ? Group::findOrFail($data->id_group)->instruktur : Instruktur::findOrFail($id_instruktur);

        // $nomor_ins = Instruktur::findOrFail($id_instruktur)->nomor_telepon;
        $wa = [
            [
                'phone' => $request->nomor_telepon,
                'message' => 'Halo *' . $request->name . '*<br><br>' .
                    'Pendaftaranmu Telah Terverifikasi, Berikut Username Dan Passwordmu' .
                    '<br><br>' . 'Username : ' . $username .
                    '<br>' . 'Password : cenarikursus' .
                    '<br><br>' . 'Tutorial untuk menggunakan aplikasi kursus.cenari.sch.id silahkan kunjungi web http://cenari.sch.id/modul-tutorial',
            ],
            [
                'phone' => $nomor_ins->nomor_telepon,
                'message' => 'Halo *' . $nomor_ins->user->name . '*<br><br>' .
                    'Murid Bernama *' . $request->name . '* Telah Menjadi Murid Didik Anda, Untuk Lebih Lanjut' . "<br><br>" .
                    'Silahkan Buka www.kursus.cenari.sch.id' . "<br>" .
                    'Tutorial untuk menggunakan aplikasi kursus.cenari.sch.id silahkan kunjungi web http://cenari.sch.id/modul-tutorial',
            ],
            [
                'phone' => env('ADMIN_NUMBER'),
                'message' => 'Halo *Admin*' . '<br>' . 'Peserta Bernama *' . $request->name . '* Telah Didaftarkan Pada Aplikasi Dengan Akun Seperti Berikut' .
                    '<br><br>' . 'Username : ' . $username .
                    '<br>' . 'Password : cenarikursus' .
                    '<br><br>' . 'Untuk Lebih Lanjut' .
                    "<br>" . 'Silahkan Buka www.kursus.cenari.sch.id' . "<br>" .
                    'Tutorial untuk menggunakan aplikasi kursus.cenari.sch.id silahkan kunjungi web http://cenari.sch.id/modul-tutorial',
            ],

        ];
        $send->multiple_text($wa);

        return redirect()->route('admin.data.peserta');
    }
    public function edit_peserta($id)
    {
        $data = Peserta::find($id);
        $ins = Instruktur::all();
        $mapels = Mapel::all();
        // return view('', ['data' => $data, 'ins' => $ins, 'mapels' => $mapels]);
        return dd($data, $ins, $mapels);
    }
    public function update_peserta(Request $request, $id)
    {
        $data = Peserta::find($id);
        $data->update($request->all());
        return redirect('');
    }
    public function delete_peserta($id)
    {
        Peserta::where('id', $id)->delete();
        return redirect()->back();
    }

    public function detail_peserta($id)
    {
        $absen = Absen::where('id_peserta', $id)->get();
        $peserta = Peserta::findOrFail($id);

        $id_instruktur = Instruktur::where('id', $peserta->id_instruktur)->value('id');
        $instruktur = User::where('id', $id_instruktur)->value('name');
        $group = Group::where('id', $peserta->id_group)->value('nama');
        $mapel = Mapel::where('id', $peserta->id_mapel)->value('nama');

        return view('admin.detail-peserta', compact([
            'absen',
            'peserta',
            'instruktur',
            'group',
            'mapel',
        ]));
        // return dd($absen, $peserta, $instruktur, $group, $mapel);
    }



    // ========= CRUD INSTRUKTUR ============
    public function instruktur()
    {
        return view('admin.data-instruktur');
    }
    public function create_instruktur()
    {
        $data = Mapel::all();
        return view('admin.create-instruktur', compact('data'));
    }
    public function creating_instruktur(Request $request)
    {
        $str = Str::random(20) . Carbon::now()->getTimestamp();
        $pekerjaan = $request->pekerjaan === 'Lainnya' ? $request->pekerjaan_lainnya : $request->pekerjaan;
        $data = Instruktur::create([
            'alamat' => $request->alamat,
            'nik' => $request->nik,
            'qrcode' => $str,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'email' => $request->email,
            'ttl' => $request->ttl,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pendidikan' => $request->pendidikan,
            'tanggal_menjadi' => $request->tanggal_menjadi,
            'NUPWK' => $request->NUPWK,
            'rekening' => $request->rekening,
            'status' => $request->status,
            'status_kerja' => $request->status_kerja,
            'pekerjaan' => $pekerjaan,
            'nomor_telepon' => $request->nomor_telepon,
        ]);
        $username = '';
        $nameParts = explode(' ', $request->name);
        if (count($nameParts) > 0) {
            $firstName = $nameParts[0];
            $secondName = count($nameParts) > 1 ? $nameParts[1] : '';
            $nameToUse = $secondName ?: $firstName;
            $username = Str::of($nameToUse . ' ' . $data->id)->slug('-');
        }
        $akun = [
            'name' => $request->name,
            'role' => 'instruktur',
            'id_instruktur' => $data->id,
            'username' => $username,
            'password' => 'cenarikursus'
        ];
        $akun['password'] = Hash::make($akun['password']);
        event(new Registered((User::create($akun))));

        $send = new Message();

        $wa = [
            [
                'phone' => $request->nomor_telepon,
                'message' => 'Halo *' . $request->name . '*<br><br>' .
                    'Pendaftaran Instrukturmu Telah Terverifikasi, Berikut Username Dan Passwordmu' .
                    '<br><br>' . 'Username : ' . $username .
                    '<br>' . 'Password : cenarikursus' .
                    "<br><br>" . 'Silahkan Buka www.kursus.cenari.sch.id' . "<br>" .
                    'Tutorial untuk menggunakan aplikasi kursus.cenari.sch.id silahkan kunjungi web http://cenari.sch.id/modul-tutorial',
            ],
            [
                'phone' => env('ADMIN_NUMBER'),
                'message' => 'Halo *Admin*' . '<br><br>' . 'Instruktur Bernama *' . $request->name . '* Telah Didaftarkan Pada Aplikasi Dengan Akun Seperti Berikut' .
                    '<br><br>' . 'Username : ' . $username .
                    '<br>' . 'Password : cenarikursus' .
                    '<br><br>' . 'Untuk Lebih Lanjut' .
                    "<br>" . 'Silahkan Buka www.kursus.cenari.sch.id' . "<br>" .
                    'Tutorial untuk menggunakan aplikasi kursus.cenari.sch.id silahkan kunjungi web http://cenari.sch.id/modul-tutorial',
            ],

        ];
        $send->multiple_text($wa);

        return redirect()->route('admin.data.instruktur');
    }
    public function edit_instruktur($id)
    {
        $data = Instruktur::findOrFail($id);
        return view('admin.detail-instruktur', compact('data'));
    }
    public function update_instruktur(Request $request, $id)
    {
        $data = Instruktur::find($id);
        $data->update($request->all());
        return redirect('');
    }
    public function delete_instruktur($id)
    {
        Instruktur::where('id', $id)->delete();
        return redirect()->back();
    }


    // ========= CRUD Group ============
    public function group()
    {
        return view('admin.data-pelatihan');
    }
    public function create_group()
    {
        $ins = InstrukturMapel::all();
        return view('admin.create-pelatihan', compact('ins'));
    }
    public function creating_group(Request $request)
    {
        $insmap = explode('-', $request->instruktur);
        $id_instruktur = $insmap[0];
        $id_mapel = $insmap[1];
        $data = Group::create([
            'id_instruktur' => $id_instruktur,
            'id_mapel' => $id_mapel,
            'nama' => $request->nama,
            'status' => 'aktif',
            'harga' => $request->harga,
            'status_pembayaran' => $request->status_pembayaran,
        ]);
        Pembayaran::create([
            'id_group' => $data->id,
            'jumlah_dibayar' => $request->jumlah_dibayar,
            'tanggal_dibayar' => $request->tanggal_dibayar,
            'deskripsi' => $request->deskripsi,
        ]);
        return redirect()->route('admin.data.pelatihan');
    }
    public function edit_group($id)
    {
        $data = Group::findOrFail($id);
        $ins = Instruktur::all();
        $peserta = Peserta::all();
        return view('', compact('data', 'ins', 'peserta'));
    }
    public function update_group(Request $request, $id)
    {
        $data = Group::find($id);
        $data->update($request->all());
        return redirect('');
    }
    public function delete_group($id)
    {
        Group::where('id', $id)->delete();
        return redirect()->back();
    }

    public function anggota_group($id) //list anggota group
    {
        $data = Group::findOrFail($id);
        return view('admin.detail-pelatihan', compact('data'));
    }
    public function tambah_peserta()
    {
        $data = Peserta::all();
        return view('', compact('data'));
    }
    public function menambah_anggota(Request $request) // tambah anggota group
    {
        $id_peserta = $request->input('id_peserta');
        $id_group = $request->input('id_group');

        Peserta::whereIn('id', $id_peserta)->update(['group_id' => $id_group]);

        return redirect()->back();

        //view untuk checkboxnya seperti dibawah ini
        // input type="checkbox" name="peserta_ids[]" value="{{ $p->id }}
    }


    // ======== CRUD MAPEL ==========
    public function mapel()
    {
        return view('admin.data-mapel');
    }
    public function create_mapel()
    {
        return view('admin.create-mapel');
    }
    public function edit_mapel($id)
    {
        $data = Mapel::findOrFail($id);
        return view('admin.edit-mapel', compact('data'));
    }
    public function delete_mapel($id)
    {
        Mapel::where('id', $id)->delete();
        return redirect()->back();
    }

    // ========= multiprogram instruktur (instruktur-mapel) =========
    public function instrukturMapel(Request $request, $id)
    {
        InstrukturMapel::where('id_instruktur', $id)->delete();

        $id_mapel = $request->input('id_mapel'); // Mengambil array id_mapel dari request

        if (is_array($id_mapel)) {
            foreach ($id_mapel as $mapel) {
                // Periksa apakah kombinasi id_instruktur dan id_mapel sudah ada
                $cek = InstrukturMapel::where('id_instruktur', $id)
                    ->where('id_mapel', $mapel)
                    ->exists();

                if (!$cek) {
                    InstrukturMapel::create([
                        'id_instruktur' => $id,
                        'id_mapel' => $mapel,
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    // =========== MATERI =========
    public function materi()
    {
        $data = Materi::all();
        return view('', compact('data'));
    }

    public function create_materi()
    {
        $data = Mapel::all();
        return view('', compact('data'));
    }

    public function creating_materi(Request $request)
    {
        $file = $request->file('file');

        $file_path = $file->storeAs('public/files');

        Materi::create([
            // 'id_instruktur' => auth()->user()->id, karena admin tidak ada id_instruktur
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
        return view('', compact('data'));
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

    // ======= ABSENSI =========
    public function absen()
    {
        $permohonan = Absen::where('status', 0)->where('id_group', null)->get(); //status 0 artinya ditahap permohonan
        $permohonangroup = Absen::select('id_group', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->where('status', 0)
            ->whereNotNull('id_group')
            ->groupBy('id_group', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->get();

        $jadwal = Absen::where('status', 1)->get(); //status 1 artinya ditahap telah diverifikasi
        $absen = Absen::where('status', 2)->get(); //status 2 artinya ditahap telah selesai/absen
        $tertolak = Absen::where('status', 3)->get(); //status 3 artinya tahap permohonan ditolak
        return view('admin.permohonan', compact([
            'permohonan',
            'jadwal',
            'absen',
            'tertolak',
            'permohonangroup',
        ]));
    }
    public function verifikasiAbsen($id)
    {
        Absen::where('id', $id)->update([
            'status' => 1
        ]);
    }

    public function selesaiAbsen($id)
    {
        Absen::where('id', $id)->update([
            'status' => 2
        ]);
    }
    public function tolakAbsen($id)
    {
        Absen::where('id', $id)->update([
            'status' => 3
        ]);
    }

    public function verifikasiAbsenGroup($id)
    {
        $id_group = Absen::findOrFail($id)->id_group;
        Absen::where('id_group', $id_group)->update([
            'status' => 1
        ]);
    }
    public function tolakAbsenGroup($id)
    {
        $id_group = Absen::findOrFail($id)->id_group;
        Absen::where('id_group', $id_group)->update([
            'status' => 3
        ]);
    }

    // ======== RESET PASSWORD USER ========
    public function resetPasswordPeserta($id)
    {
        User::where('id_peserta', $id)->update([
            'password' => bcrypt('cenarikursus')
        ]);
        return redirect()->back();
    }
    public function resetPasswordIns($id)
    {
        User::where('id_instruktur', $id)->update([
            'password' => bcrypt('cenarikursus')
        ]);
        return redirect()->back();
    }

    public function export(Request $request)
    {
        $now = Carbon::now();

        if ($request->tanggal) {
            $request->validate([
                'tanggal' => 'date_format:Y-m',
            ]);

            $monthInput = $request->input('tanggal');
            $date = Carbon::createFromFormat('Y-m', $monthInput);
            $month = $date->format('m'); // 'm' gives the month with leading zero
            $year = $date->format('Y');
            $tanggal_export = $monthInput;

            // Filter $biodata based on the month and year
            $biodata = Peserta::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        } else {
            // If tanggal is not provided, filter by the current month and year
            $biodata = Peserta::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->get();
            $tanggal_export = $now->format('Y-m');
        }
        $exportData = [];

        foreach ($biodata as $peserta) {
            $nama = User::where('id_peserta', $peserta->id)->value('name');
            $id_group = Peserta::where('id', $peserta->id)->value('id_group');
            $pembayaran = Peserta::where('id', $peserta->id)->value('status_pembayaran');
            if ($id_group) {
                $group = Group::where('id', $id_group)->value('nama');

                $id_mapel = Group::where('id', $id_group)->value('id_mapel');
                $mapel = Mapel::where('id', $id_mapel)->value('nama');

                $id_instruktur = Group::where('id', $id_group)->value('id_instruktur');
                $instruktur = User::where('id_instruktur', $id_instruktur)->value('name');
            } else {
                $group = '-';
                $mapel = Mapel::where('id', $peserta->id_mapel)->value('nama');
                $instruktur = User::where('id', $peserta->id_instruktur)->value('name');
            }
            $absen = Absen::where('id_peserta', $peserta->id)->count(); // Mengambil semua data absen untuk peserta tersebut

            // Tambahkan data peserta ke dalam array exportData
            $exportData[] = [
                'biodata' => $peserta,
                'nama' => $nama,
                'absen' => $absen,
                'mapel' => $mapel,
                'instruktur' => $instruktur,
                'group' => $group,
                'pembayaran' => $pembayaran,
            ];
        }

        return (new PesertaExport($exportData))->download('Peserta Didik ' . $tanggal_export . '.xlsx');
    }

    // ======= PESAN =========
    public function pesan()
    {
        $data = Pesan::all();
        return view('', compact('data'));
    }

    public function tanggapan(Request $request, $id)
    {
        $data = Pesan::find($id);
        $data->update($request->all());
        return redirect('');
    }

    public function exportPembayaran(Request $request)
    {
        $now = Carbon::now();
        // return dd($now);

        $payment = [];

        if ($request->tanggal) {
            $request->validate([
                'tanggal' => 'date_format:Y-m',
            ]);

            $monthInput = $request->input('tanggal');
            $date = Carbon::createFromFormat('Y-m', $monthInput);
            $month = $date->format('m');
            $year = $date->format('Y');
            $tanggal_export = $monthInput;

            $payment = Pembayaran::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        } else {
            $payment = Pembayaran::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->get();
            $tanggal_export = $now->format('Y-m');
        }
        return (new PembayaranExport($payment))->download('Data Pembayaran ' . $tanggal_export . '.xlsx');


        // foreach ($payment as $pay) {
        // $nama = User::where('id_peserta', $pay->id_peserta)->value('name');
        // $id_group = Peserta::where('id', $pay->id_peserta)->value('id_group');
        // $nama = $payment->id_group ? $payment->group->nama : $payment->peserta->user->name;
        // $status = Peserta::where('id', $pay->id_peserta)->value('status_pembayaran');
        // if ($id_group) {
        //     $group = Group::where('id', $id_group)->value('nama');

        //     $id_mapel = Group::where('id', $id_group)->value('id_mapel');
        //     $mapel = Mapel::where('id', $id_mapel)->value('nama');
        //     $harga = Mapel::where('id', $id_mapel)->value('harga');
        // } else {
        //     $group = '-';
        //     $mapel = Mapel::where('id', $pay->id_mapel)->value('nama');
        //     $harga = Mapel::where('id', $pay->id_mapel)->value('harga');
        // }
        // }

        // $sheetTitle = "Pembayaran_" . $tanggal_export;
        // $shortenedTitle = strlen($sheetTitle) > 31 ? substr($sheetTitle, 0, 31) : $sheetTitle;

        // // return (new PembayaranExport($paydata))->download('pembayaran.xlsx');
    }
}