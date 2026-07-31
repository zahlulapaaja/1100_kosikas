<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('maskapai_id')->constrained('maskapais');
            $table->foreignId('origin_wilayah_id')->constrained('wilayahs');
            $table->foreignId('destination_wilayah_id')->constrained('wilayahs');
            $table->string('flight_no', 20);
            $table->date('departure_date');
            $table->string('dep_time', 10);
            $table->string('arr_time', 10);
            $table->string('subclass', 5)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
