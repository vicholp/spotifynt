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
            $table->unsignedBigInteger('artist_id')->references('id')->on('artist')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->unsignedBigInteger('release_group_id')->references('id')->on('release_group')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id')->references('id')->on('release')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('played_track_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->references('id')->on('track')->onDelete('cascade')->onUpdate('cascade')->change();
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade')->change();
            $table->unsignedBigInteger('server_id')->references('id')->on('server')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('searched_term_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('showed_release_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id')->references('id')->on('release')->onDelete('cascade')->onUpdate('cascade')->change();
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('skipped_track_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->references('id')->on('track')->onDelete('cascade')->onUpdate('cascade')->change();
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade')->change();
            $table->unsignedBigInteger('server_id')->references('id')->on('server')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('server_track', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->references('id')->on('server')->onDelete('cascade')->onUpdate('cascade')->change();
            $table->unsignedBigInteger('track_id')->references('id')->on('track')->onDelete('cascade')->onUpdate('cascade')->change();
        });

        Schema::table('server_user', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->references('id')->on('server')->onDelete('cascade')->onUpdate('cascade')->change();
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade')->change();
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
            $table->unsignedBigInteger('artist_id')->references('id')->on('artist')->change();
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->unsignedBigInteger('release_group_id')->references('id')->on('release_group')->change();
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id')->references('id')->on('release')->change();
        });

        Schema::table('played_track_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->references('id')->on('track')->change();
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->change();
            $table->unsignedBigInteger('server_id')->references('id')->on('server')->change();
        });

        Schema::table('searched_term_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->change();
        });

        Schema::table('showed_release_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id')->references('id')->on('release')->change();
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->change();
        });

        Schema::table('skipped_track_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->references('id')->on('track')->change();
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->change();
            $table->unsignedBigInteger('server_id')->references('id')->on('server')->change();
        });

        Schema::table('server_track', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->references('id')->on('server')->change();
            $table->unsignedBigInteger('track_id')->references('id')->on('track')->change();
        });

        Schema::table('server_user', function (Blueprint $table) {
            $table->unsignedBigInteger('server_id')->references('id')->on('server')->change();
            $table->unsignedBigInteger('user_id')->references('id')->on('user')->change();
        });
    }
};
