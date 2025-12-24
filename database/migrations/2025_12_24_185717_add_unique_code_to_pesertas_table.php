<?php

use App\Models\Peserta;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        // 1. Buat kolomnya dulu (nullable agar tidak error saat pembuatan)
        Schema::table('pesertas', function (Blueprint $table) {
            $table->string('unique_code')->nullable()->after('id');
        });

        // 2. Isi data yang sudah ada
        $pesertas = Peserta::all();
        foreach ($pesertas as $p) {
            $p->update([
                'unique_code' => Str::random(20) . Carbon::now()->getTimestamp()
            ]);
        }

        // 3. (Opsional) Ubah kolom jadi NOT NULL dan UNIQUE setelah data terisi
        Schema::table('pesertas', function (Blueprint $table) {
            $table->string('unique_code')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropColumn('unique_code');
        });
    }
};