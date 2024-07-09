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
        Schema::create('played_track_stats', function (Blueprint $table) {
            $table->id();

<<<<<<< HEAD
            $table->foreignId('track_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('server_id')->constrained();
=======
            $table->foreignId('track_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
>>>>>>> 6c190f9 (wip)

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
        Schema::dropIfExists('played_track_stats');
    }
};
