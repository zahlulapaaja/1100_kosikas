
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('penerbangans', 'punya_transit')) {
            Schema::table('penerbangans', function (Blueprint $table) {
                $table->boolean('punya_transit')
                    ->default(false)
                    ->after('jam_sampai');
            });
        }

        if (!Schema::hasColumn('penerbangans', 'transit_wilayah_id')) {
            Schema::table('penerbangans', function (Blueprint $table) {
                $table->foreignId('transit_wilayah_id')
                    ->nullable()
                    ->after('punya_transit')
                    ->constrained('wilayahs')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('penerbangans', 'transit_durasi_menit')) {
            Schema::table('penerbangans', function (Blueprint $table) {
                $table->unsignedSmallInteger('transit_durasi_menit')
                    ->nullable()
                    ->after('transit_wilayah_id');
            });
        }

        if (!Schema::hasColumn('penerbangans', 'transit_maskapai_id')) {
            Schema::table('penerbangans', function (Blueprint $table) {
                $table->foreignId('transit_maskapai_id')
                    ->nullable()
                    ->after('transit_durasi_menit')
                    ->constrained('maskapais')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('penerbangans', function (Blueprint $table) {
            if (Schema::hasColumn('penerbangans', 'transit_maskapai_id')) {
                $table->dropConstrainedForeignId('transit_maskapai_id');
            }

            if (Schema::hasColumn('penerbangans', 'transit_durasi_menit')) {
                $table->dropColumn('transit_durasi_menit');
            }

            if (Schema::hasColumn('penerbangans', 'transit_wilayah_id')) {
                $table->dropConstrainedForeignId('transit_wilayah_id');
            }

            if (Schema::hasColumn('penerbangans', 'punya_transit')) {
                $table->dropColumn('punya_transit');
            }
        });
    }
};
