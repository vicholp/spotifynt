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
<<<<<<< HEAD:database/migrations/2024_02_25_211915_create_server_release_groups_table.php
        Schema::create('release_group_server', function (Blueprint $table) {
            $table->id();

            $table->foreignId('server_id')->constrained();
            $table->foreignId('release_group_id')->constrained();

            $table->timestamps();
=======
        Schema::table('played_track_stats', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('server_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
>>>>>>> 6c190f9 (wip):database/migrations/2022_09_15_174428_modify_played_track_stats.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_group_server');
    }
};
