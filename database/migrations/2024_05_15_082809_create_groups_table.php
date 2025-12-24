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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_instruktur')->nullable()->constrained('instrukturs')->onDelete('set null');
            $table->foreignId('id_mapel')->nullable()->constrained('mapels')->onDelete('set null');
            $table->string('nama');
            $table->string('status');
            $table->integer('harga');
            $table->string('status_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
