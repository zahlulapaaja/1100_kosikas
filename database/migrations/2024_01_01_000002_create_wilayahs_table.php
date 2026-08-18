<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayahs', function (Blueprint $table) {
            $table->id();
            $table->string('airport_name', 150);
            $table->string('code_iata', 3)->unique();
            $table->string('code_icao', 4)->unique();
            $table->string('city_name', 100);
            $table->string('province_name', 100)->nullable();
            $table->string('country', 100)->default('Indonesia');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->enum('type', ['domestic', 'international'])->default('domestic');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayahs');
    }
};
