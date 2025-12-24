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
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peserta')->constrained('pesertas');
            $table->foreignId("id_instruktur")->constrained('instrukturs');
            $table->foreignId("id_group")->nullable();
            $table->string("nama_peserta")->nullable();
            $table->string("nama_instruktur")->nullable();
            $table->string("nama_group")->nullable();
            $table->string("keterangan");
            $table->timestamp("waktu_mulai");
            $table->timestamp("waktu_absen")->nullable();
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
