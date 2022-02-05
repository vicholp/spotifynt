<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('mb_id', 500)->unique()->nullable();
            $table->integer('beets_id');
            $table->string('name', 1000);
            $table->string('path', 1000);
            $table->foreignId('album_id')->constrained();
            $table->integer('track_position')->nullable();

            $table->integer('length');
            $table->string('format', 100);
            $table->integer('bitrate');
            $table->string('bit_depht', 100);
            $table->string('sample_rate', 100);

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

            $table->jsonb('beets_tags')->nullable();
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
}
