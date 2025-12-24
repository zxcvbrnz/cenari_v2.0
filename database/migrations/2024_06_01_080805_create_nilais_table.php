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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peserta')->nullable()->constrained('pesertas')->onDelete('set null');
            $table->string('materi_1')->nullable();
            $table->string('materi_2')->nullable();
            $table->string('materi_3')->nullable();
            $table->string('materi_4')->nullable();
            $table->string('materi_5')->nullable();
            $table->string('materi_6')->nullable();
            $table->string('materi_7')->nullable();
            $table->string('materi_8')->nullable();
            $table->string('materi_9')->nullable();
            $table->string('materi_10')->nullable();
            $table->integer('nilai_1')->nullable();
            $table->integer('nilai_2')->nullable();
            $table->integer('nilai_3')->nullable();
            $table->integer('nilai_4')->nullable();
            $table->integer('nilai_5')->nullable();
            $table->integer('nilai_6')->nullable();
            $table->integer('nilai_7')->nullable();
            $table->integer('nilai_8')->nullable();
            $table->integer('nilai_9')->nullable();
            $table->integer('nilai_10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};