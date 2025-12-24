<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminOrInstruktur;
use App\Http\Middleware\Instruktur;
use App\Http\Middleware\Peserta;
use App\Http\Middleware\Materi;

// use Silvanix\Wablas\Message;

Route::get('/peserta/{unique_code}', [AdminController::class, 'unique_code_peserta']);


Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/tesmsg', function () {
//     $send = new Message();

//     $wa = [
//             [
//             'phone' => '089691884833',
//             'message' =>
//                 "Halo *Admin*\n" .
//                 "Permohonan Jadwal Telah Disetujui\n" .
//                 "```\n" .
//                 "Instruktur     : Udin Samoh\n" .
//                 "Peserta Didik  : Markonah NG\n" .
//                 "Tanggal/Waktu  : 30 July 2025 - 19:00\n" .
//                 "Keterangan     : terakhir\n" .
//                 "```\n" .
//                 "Silakan cek informasi lengkap di website kami:\n" .
//                 "www.kursus.cenari.sch.id",

//             ],
//     ];

//     $send->multiple_text($wa);

//     return 'Pesan berhasil dikirim (cek WhatsApp)';
// });

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

        Route::view('/masukan/{id}', 'masukan-detail')->name('masukan.detail');
        Route::get('/export-peserta-pdf/{id}', [PdfController::class, 'GeneratePDF'])->name('export.peserta.pdf');
        Route::view('/settings/general', 'settings/general')->name('setting.general');


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
    });

    Route::view('profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';