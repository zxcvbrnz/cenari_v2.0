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
        Schema::create('instrukturs', function (Blueprint $table) {
            $table->id();
            $table->string('alamat')->nullable();
            $table->string('nik')->nullable();
            $table->string('qrcode')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('email')->nullable();
            $table->string('ttl')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('tanggal_menjadi')->nullable();
            $table->string('NUPWK')->nullable();
            $table->string('rekening')->nullable();
            $table->string('status')->nullable();
            $table->string('status_kerja')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string("nomor_telepon")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instrukturs');
    }
};
