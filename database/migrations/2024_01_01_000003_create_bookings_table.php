<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('agency_name', 100)->default('TRAVEL AGENCY');
            $table->string('agency_tagline', 150)->nullable();
            $table->string('pnr', 20);
            $table->date('issued_date');
            $table->string('currency', 10)->default('IDR');
            $table->decimal('total_fare', 14, 2)->default(0);
            $table->string('fare_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
