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

            $table->foreignId('server_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('track_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('format', 100)->nullable();
            $table->unsignedInteger('bitrate')->nullable();
            $table->unsignedInteger('length')->nullable();
            $table->unsignedInteger('sample_rate')->nullable();
            $table->unsignedInteger('bit_depth')->nullable();
            $table->unsignedInteger('channels')->nullable();
            $table->unsignedInteger('size')->nullable();

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
