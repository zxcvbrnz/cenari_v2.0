<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jam_digitals', function (Blueprint $table) {
            $table->id();
            $table->text('running_text');
            $table->string('sub_text', 20)->default('RTC OK');
            $table->integer('speed')->default(35); // Kecerpatan scroll (ms)
            $table->integer('size')->default(1);  // 1: Normal, 2: Besar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_digitals');
    }
};
