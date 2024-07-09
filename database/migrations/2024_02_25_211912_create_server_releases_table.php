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
        Schema::create('release_server', function (Blueprint $table) {
            $table->id();

<<<<<<< HEAD:database/migrations/2024_02_25_211912_create_server_releases_table.php
            $table->foreignId('server_id')->constrained();
            $table->foreignId('release_id')->constrained();
=======
            $table->foreignId('art_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('release_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
>>>>>>> 6c190f9 (wip):database/migrations/2022_08_22_015133_create_art_release_table.php

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_server');
    }
};
