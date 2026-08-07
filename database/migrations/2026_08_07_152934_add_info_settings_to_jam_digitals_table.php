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
            // Menambahkan kolom pengaturan mode info tetap (Web & Kontak)
            $table->boolean('enableInfo')->default(true)->after('animType');
            $table->string('webUrl')->default('cenari.sch.id')->after('enableInfo');
            $table->string('contactInfo')->default('081234567890')->after('webUrl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jam_digitals', function (Blueprint $table) {
            // Drop kolom jika migration di-rollback
            $table->dropColumn(['enableInfo', 'webUrl', 'contactInfo']);
        });
    }
};
