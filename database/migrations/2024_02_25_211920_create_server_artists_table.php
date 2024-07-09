<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
<<<<<<< HEAD:database/migrations/2024_02_25_211920_create_server_artists_table.php
        Schema::create('artist_server', function (Blueprint $table) {
            $table->id();

            $table->foreignId('server_id')->constrained();
            $table->foreignId('artist_id')->constrained();

            $table->timestamps();
=======
        Schema::table('skipped_track_stats', function (Blueprint $table) {
            $table->foreignId('server_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
>>>>>>> 6c190f9 (wip):database/migrations/2022_09_15_174544_modify_skipped_track_stats.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_server');
    }
};
