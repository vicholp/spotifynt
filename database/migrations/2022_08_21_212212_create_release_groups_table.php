<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_groups', function (Blueprint $table) {
            $table->id();

            $table->string('mb_releasegroup_id', 50);
            $table->string('title', 500);
            $table->string('type', 500);
            $table->foreignId('artist_id')->constrained();

            $table->json('mb_data');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('release_groups');
    }
};
