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
        Schema::table('files', function (Blueprint $table) {
            $table->bigInteger('size_bytes')->nullable();
            $table->string('checksum_md5')->nullable();

            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();

            $table->bigInteger('bitrate_bps')->nullable();
            $table->bigInteger('sample_rate_hz')->nullable();
            $table->bigInteger('length_s')->nullable();

            $table->string('source')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn([
                'size_bytes',
                'checksum_md5',
                'mime_type',
                'extension',
                'bitrate_bps',
                'sample_rate_hz',
                'length_s',
                'source',
            ]);
        });
    }
};
