<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maskapais', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code_iata', 10)->unique();
            $table->string('code_icao', 10)->unique();
            $table->string('group')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maskapais');
    }
};
