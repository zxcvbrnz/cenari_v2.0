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
            // Menambahkan kolom pengaturan mode tampilan aktif
            $table->boolean('enableClock')->default(true)->after('size');
            $table->boolean('enableText')->default(true)->after('enableClock');
            $table->boolean('enableAnim')->default(true)->after('enableText');
            $table->integer('animType')->default(1)->after('enableAnim'); // 1: Heartbeat, 2: Radar, 3: Equalizer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jam_digitals', function (Blueprint $table) {
            // Drop kolom jika migration di-rollback
            $table->dropColumn(['enableClock', 'enableText', 'enableAnim', 'animType']);
        });
    }
};
