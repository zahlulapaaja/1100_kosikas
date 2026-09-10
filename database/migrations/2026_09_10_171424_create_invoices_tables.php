<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->nullable();
            $table->date('issued_date');
            $table->string('orderer_name')->nullable();
            $table->string('orderer_address')->nullable();
            $table->string('orderer_phone')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('signer_name')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['flight', 'extra'])->default('flight');

            // snapshot data, biar invoice tetap stabil walau data booking berubah
            $table->string('passenger_name')->nullable();
            $table->string('maskapai_name')->nullable();
            $table->string('route_text')->nullable();
            $table->string('flight_date_text')->nullable();
            $table->string('label')->nullable(); // untuk item 'extra', mis. "Biaya Reschedule"

            $table->decimal('amount', 15, 2)->default(0); // boleh negatif (refund/diskon)
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
