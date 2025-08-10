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
        Schema::create('release_groups', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('mb_id')->nullable()->unique();
            $table->string('alpha_id')->nullable()->unique();
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_groups');
    }
};
