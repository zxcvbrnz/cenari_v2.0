<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\LaporanKeuanganPdfController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminOrInstruktur;
use App\Http\Middleware\Instruktur;
use App\Http\Middleware\Peserta;
use App\Http\Middleware\Materi;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\AutoLoginController;
use Silvanix\Wablas\Message;
use App\Facades\Whatsapp;
use App\Livewire\WhatsAppChat;
use App\Models\Setting;

Route::prefix('test-whatsapp')->group(function () {

    /**
     * Uji Coba 1: Mengirim Pesan Teks Biasa
     * Akses URL: domain-anda.test/test-whatsapp/text?to=08xxxxxxxxxx
     */
    Route::get('/text', function () {
        $to = request('to');

        if (!$to) {
            return response()->json(['error' => 'Masukkan parameter nomor tujuan (?to=08xxxx) pada URL'], 400);
        }

        $message = "Halo, ini adalah pesan uji coba teks biasa dari aplikasi Laravel Cenari!";
        $status = Whatsapp::sendText($to, $message);

        if ($status) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pesan teks berhasil dikirim ke ' . $to,
                'note' => 'Pesan hanya masuk jika nomor tersebut berinteraksi dengan nomor bisnis dalam 24 jam terakhir.'
            ]);
        }

        return response()->json(['status' => 'failed', 'message' => 'Gagal mengirim pesan teks. Periksa log Laravel untuk detailnya.'], 500);
    });

    /**
     * Uji Coba 2: Mengirim Pesan Template (Blast / Notifikasi Awal)
     * Akses URL: domain-anda.test/test-whatsapp/template?to=08xxxxxxxxxx
     */
    Route::get('/template', function () {
        $to = request('to');

        if (!$to) {
            return response()->json(['error' => 'Masukkan parameter nomor tujuan (?to=08xxxx) pada URL'], 400);
        }

        // Contoh menggunakan template default Meta yaitu 'hello_world' (tidak memerlukan variabel parameters)
        // Jika menggunakan template custom, isi array dengan parameter {{1}}, {{2}}, dst.
        $templateName = 'hello_world';
        $parameters = [];
        $language = 'en_US'; // Sesuaikan bahasa template 'hello_world' (biasanya en_US)

        $status = Whatsapp::sendTemplate($to, $templateName, $parameters, $language);

        if ($status) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pesan template "' . $templateName . '" berhasil dikirim ke ' . $to
            ]);
        }

        return response()->json(['status' => 'failed', 'message' => 'Gagal mengirim pesan template. Periksa log Laravel.'], 500);
    });
});

// use Silvanix\Wablas\Message;

Route::get('/peserta/{unique_code}', [AdminController::class, 'unique_code_peserta']);

Route::post('/midtrans/callback', [PaymentCallbackController::class, 'callback']);

Route::get('/auto-login', [AutoLoginController::class, 'handleLogin']);


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/tesmsgasalajamantap', function () {
    $send = new Message();

    $wa = [
        [
            'phone' => '089691884833',
            'message' =>
            "Halo *Admin*\n" .
                "Permohonan Jadwal Telah Disetujui\n" .
                "```\n" .
                "Instruktur     : Udin Samoh\n" .
                "Peserta Didik  : Markonah NG\n" .
                "Tanggal/Waktu  : 30 July 2025 - 19:00\n" .
                "Keterangan     : terakhir\n" .
                "```\n" .
                "Silakan cek informasi lengkap di website kami:\n" .
                "www.kursus.cenari.sch.id\n\n" .
                "----------------------------------------\n" .
                "*Catatan:* Ini adalah akun bot otomatis, mohon tidak membalas chat ini. Jika ada pertanyaan lebih lanjut, silakan hubungi via WhatsApp ke *08134021142*.",

        ],
    ];

    $send->multiple_text($wa);

    return 'Pesan berhasil dikirim (cek WhatsApp)';
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role == 'admin') {
            return app(AdminController::class)->beranda();
        } elseif (auth()->user()->role == 'instruktur') {
            return app(InstrukturController::class)->beranda();
        } elseif (auth()->user()->role == 'peserta') {
            return app(PesertaController::class)->beranda();
        }
    })->name('dashboard');

    Route::view('/masukan', 'masukan')->name('masukan');

    // Route::get('materi-pembelajaran/buat', [AdminController::class, 'a'])->name('materi.create');
    Route::view('/materi-pembelajaran', 'materi.index')->name('materi')->middleware(Materi::class);
    Route::middleware([AdminOrInstruktur::class])->group(function () {
        Route::view('/materi-pembelajaran/buat', 'materi.create')->name('materi.create');
        Route::view('/materi-pembelajaran/{id}/edit', 'materi.edit')->name('materi.edit');
    });
    Route::view('/materi-pembelajaran/{id}', 'materi.detail')->name('materi.detail');

    // ========== ROUTE ADMIN =============
    Route::middleware([Admin::class])->group(function () {

        if (Setting::findOrFail(3)->value === 'ON') {
            Route::get('/whatsapp-chat', WhatsAppChat::class)->name('whatsapp.chat');
        }

        Route::view('/masukan/{id}', 'masukan-detail')->name('masukan.detail');
        Route::get('/export-peserta-pdf/{id}', [PdfController::class, 'GeneratePDF'])->name('export.peserta.pdf');
        Route::get('/laporan/keuangan/pdf/{bulan}', [LaporanKeuanganPdfController::class, 'bulanan'])->name('laporan.keuangan.pdf');

        Route::view('/settings/general', 'settings/general')->name('setting.general');

        Route::view('/detail-data-card', 'detail-data-card')->name('admin.detail.datacard');


        // permohonan
        Route::get('/permohonan', [AdminController::class, 'absen'])->name('permohonan');
        Route::get('/verifikasiabsen/{id}', [AdminController::class, 'verifikasiAbsen'])->name('verifikasiAbsen');
        Route::get('/tolakabsen/{id}', [AdminController::class, 'tolakAbsen'])->name('tolakAbsen');
        Route::get('/selesaiabsen', [AdminController::class, 'selesaiAbsen'])->name('selesaiAbsen');

        Route::view('/pembayaran', 'admin.pembayaran')->name('admin.pembayaran');
        Route::view('/jadwal-private', 'admin.jadwal-private')->name('admin.jadwal.private');
        Route::view('/jadwal-pelatihan', 'admin.jadwal-pelatihan')->name('admin.jadwal.pelatihan');
        Route::view('/jadwal-pelatihan/view/{id_group}/{id_instruktur}/{waktu_mulai}/{keterangan}', 'admin.view-pelatihan-group')->name('admin.jadwal.pelatihan.view');


        Route::post('/export', [AdminController::class, 'export']);
        Route::post('/export-pembayaran', [AdminController::class, 'exportPembayaran']);

        Route::view('/sertifikat-peserta-didik', 'sertifikat.index')->name('admin.sertifikat');


        Route::view('/laporan-keuangan', 'laporan.keuangan')->name('admin.laporan.keuangan');


        // CRUD PESERTA
        Route::get('/data-peserta', [AdminController::class, 'peserta'])->name('admin.data.peserta');
        Route::get('/data-peserta/detail/{id}', [AdminController::class, 'detail_peserta'])->name('admin.data.peserta.detail');
        Route::get('/tambah-peserta', [AdminController::class, 'create_peserta'])->name('admin.create.peserta');
        Route::post('/tambah-peserta', [AdminController::class, 'creating_peserta'])->name('admin.peserta.creating');
        Route::get('/update-peserta/{id}', [AdminController::class, 'edit_peserta'])->name('admin.edit.peserta');

        // CRUD Instruktur
        Route::get('/data-instruktur', [AdminController::class, 'instruktur'])->name('admin.data.instruktur');
        Route::get('/data-instruktur/update/{id}', [AdminController::class, 'edit_instruktur'])->name('admin.data.instruktur.update');
        Route::get('/tambah-instruktur', [AdminController::class, 'create_instruktur'])->name('admin.create.instruktur');
        Route::post('/tambah-instruktur', [AdminController::class, 'creating_instruktur'])->name('admin.instruktur.creating');

        // CRUD Pelatihan
        Route::get('/data-pelatihan', [AdminController::class, 'group'])->name('admin.data.pelatihan');
        Route::get('/data-pelatihan/detail/{id}', [AdminController::class, 'anggota_group'])->name('admin.data.pelatihan.detail');
        Route::get('/tambah-pelatihan', [AdminController::class, 'create_group'])->name('admin.create.pelatihan');
        Route::post('/tambah-pelatihan', [AdminController::class, 'creating_group'])->name('admin.pelatihan.creating');
        Route::get('/edit-pelatihan', [AdminController::class, 'edit_group'])->name('admin.pelatihan.edit');

        // CRUD Mata Pelajaran
        Route::get('/data-mapel', [AdminController::class, 'mapel'])->name('admin.data.mapel');
        Route::get('/tambah-mapel', [AdminController::class, 'create_mapel'])->name('admin.create.mapel');
        Route::post('/tambah-mapel', [AdminController::class, 'creating_mapel'])->name('admin.mapel.creating');
        Route::get('/update-mapel/{id}', [AdminController::class, 'edit_mapel'])->name('admin.data.mapel.edit');
    });


    // ========= ROUTE INSTRUKTUR =============
    Route::middleware([Instruktur::class])->group(function () {
        Route::view('/buat-permohonan', 'instruktur.buat-permohonan')->name('instruktur.buat.permohonan');
        Route::view('/peserta-didik', 'instruktur.peserta-didik')->name('instruktur.peserta.didik');
        // Route::view('/peserta-didik/detail/{id}', 'instruktur.detail-peserta-didik')->name('instruktur.peserta.didik.detail');
        Route::view('/pelatihan', 'instruktur.pelatihan')->name('instruktur.pelatihan');
        Route::view('/program-kursus', 'instruktur.program')->name('instruktur.program');

        Route::get('/peserta-didik/detail/{id}', [AdminController::class, 'detail_peserta'])->name('instruktur.peserta.didik.detail');
        Route::get('/pelatihan/detail/{id}', [AdminController::class, 'anggota_group'])->name('instruktur.pelatihan.detail');
    });


    // ========= ROUTE PESERTA ==============
    Route::middleware([Peserta::class])->group(function () {
        Route::get('/absensi', [PesertaController::class, 'absensi'])->name('peserta.absensi');
        Route::get('/absen/{token}', [PesertaController::class, 'absen']);
        Route::get('/penilaian', [PesertaController::class, 'penilaian'])->name('peserta.penilaian');
        Route::view('/anggota-pelatihan', 'peserta.anggota-pelatihan')->name('peserta.anggota.pelatihan');
        Route::view('/riwayat-pembayaran', 'peserta.pembayaran')->name('peserta.pembayaran');
    });

    Route::view('profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
