<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom 'contact'
            $table->string('barcode')->nullable()->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('barcode');
        });
    }
};