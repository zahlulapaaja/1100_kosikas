<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerbangans', function (Blueprint $table) {
            $table->id();

            // Relasi wilayah
            $table->foreignId('wilayah_asal_id')
                ->constrained('wilayahs')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('wilayah_tujuan_id')
                ->constrained('wilayahs')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Relasi maskapai
            $table->foreignId('maskapai_id')
                ->constrained('maskapais')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Jadwal penerbangan
            $table->time('jam_berangkat');
            $table->time('jam_sampai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerbangans');
    }
};
