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
        Schema::table('release_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->unsignedBigInteger('release_group_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });

        Schema::table('played_track_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
            $table->unsignedBigInteger('server_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });

        Schema::table('searched_term_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });

        Schema::table('showed_release_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });

        Schema::table('skipped_track_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
            $table->unsignedBigInteger('server_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });

        Schema::table('server_track', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
            $table->unsignedBigInteger('track_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });

        Schema::table('server_user', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade')->cascadeOnUpdate('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void`
     */
    public function down()
    {
        Schema::table('release_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id')->constrained()->change();
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->unsignedBigInteger('release_group_id')->constrained()->change();
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id')->constrained()->change();
        });

        Schema::table('played_track_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->constrained()->change();
            $table->unsignedBigInteger('user_id')->constrained()->change();
            $table->unsignedBigInteger('server_id')->constrained()->change();
        });

        Schema::table('searched_term_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->constrained()->change();
        });

        Schema::table('showed_release_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id')->constrained()->change();
            $table->unsignedBigInteger('user_id')->constrained()->change();
        });

        Schema::table('skipped_track_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->constrained()->change();
            $table->unsignedBigInteger('user_id')->constrained()->change();
            $table->unsignedBigInteger('server_id')->constrained()->change();
        });

        Schema::table('server_track', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->constrained()->change();
            $table->unsignedBigInteger('track_id')->constrained()->change();
        });

        Schema::table('server_user', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->constrained()->change();
            $table->unsignedBigInteger('user_id')->constrained()->change();
        });
    }
};
