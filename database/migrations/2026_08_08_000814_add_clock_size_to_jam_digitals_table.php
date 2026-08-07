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
        Schema::table('jam_digitals', function (Blueprint $table) {
            $table->integer('clockSize')->default(1)->after('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jam_digitals', function (Blueprint $table) {
            $table->dropColumn('clockSize');
        });
    }
};
