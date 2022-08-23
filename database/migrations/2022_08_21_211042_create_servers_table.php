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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('path', 1024);

            $table->foreignId('owner_id')->constrained('users');

            $table->enum('visibility', ['public', 'private']);
            $table->enum('access', ['restricted', 'private']);

            $table->dateTime('last_sync')->nullable();
            $table->dateTime('last_full_sync')->nullable();

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
        Schema::dropIfExists('servers');
    }
};
