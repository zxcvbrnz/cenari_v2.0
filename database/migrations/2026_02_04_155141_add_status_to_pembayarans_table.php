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
        Schema::table('pembayarans', function (Blueprint $table) {
            // Menambahkan kolom status setelah kolom total_price (atau sesuaikan posisinya)
            $table->string('status')->default('pending')->after('deskripsi');

            // Jika Anda ingin menggunakan ENUM agar lebih aman (opsional):
            // $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
