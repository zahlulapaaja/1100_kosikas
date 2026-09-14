<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('hotel_name')->nullable()->after('route_text');
            $table->string('hotel_location')->nullable()->after('hotel_name');
            $table->date('checkin_date')->nullable()->after('hotel_location');
            $table->date('checkout_date')->nullable()->after('checkin_date');
        });
    }

    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn(['hotel_name', 'hotel_location', 'checkin_date', 'checkout_date']);
        });
    }
};
