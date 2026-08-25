<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jam_digitals', function (Blueprint $table) {
            $table->integer('clock_size')->default(1)->after('size');
            $table->boolean('matrix_power')->default(true)->after('enable_info');
            $table->json('schedule')->nullable()->after('matrix_power');
        });
    }

    public function down(): void
    {
        Schema::table('jam_digitals', function (Blueprint $table) {
            $table->dropColumn(['clock_size', 'matrix_power', 'schedule']);
        });
    }
};
