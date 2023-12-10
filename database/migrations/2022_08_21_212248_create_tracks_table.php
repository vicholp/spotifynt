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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();

            $table->string('title', 1000);
            $table->foreignId('release_id')->constrained();
            $table->integer('track_position')->nullable();

            $table->integer('length')->nullable();
            $table->float('average_loudness')->nullable();
            $table->integer('bpm')->nullable();
            $table->float('danceable')->nullable();
            $table->string('genre_rosamerica', 100)->nullable();
            $table->string('language', 10)->nullable();
            $table->float('mood_acoustic')->nullable();
            $table->float('mood_aggressive')->nullable();
            $table->float('mood_electronic')->nullable();
            $table->float('mood_happy')->nullable();
            $table->float('mood_party')->nullable();
            $table->float('mood_relaxed')->nullable();
            $table->float('mood_sad')->nullable();
            $table->string('moods_mirex', 100)->nullable();
            $table->string('voice_instrumental', 100)->nullable();

            $table->string('mb_recording_id', 500);
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
        Schema::dropIfExists('tracks');
    }
};
