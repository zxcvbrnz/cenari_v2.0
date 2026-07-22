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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number'); // Nomor customer (misal: 628123456789)
            $table->enum('direction', ['inbound', 'outbound']); // inbound = dari customer, outbound = dari kita
            $table->text('body'); // Isi pesan
            $table->string('wam_id')->nullable(); // WhatsApp Message ID dari Meta
            $table->string('status')->default('sent'); // sent, delivered, read, failed
            $table->timestamps();

            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};