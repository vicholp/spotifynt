<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_track', function (Blueprint $table) {
            $table->id();

            $table->foreignId('server_id')->constrained();
            $table->foreignId('track_id')->constrained();

            $table->string('path');
            $table->integer('beets_id');

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
        Schema::dropIfExists('server_track');
    }
};
