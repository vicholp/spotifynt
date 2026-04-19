<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('recordings', function (Blueprint $table) {
            $table->text('lyrics')->nullable();
            $table->text('syncedLyrics')->nullable();
            $table->boolean('instrumental')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recordings', function (Blueprint $table) {
            $table->dropColumn('lyrics');
            $table->dropColumn('syncedLyrics');
            $table->dropColumn('instrumental');
        });
    }
};
