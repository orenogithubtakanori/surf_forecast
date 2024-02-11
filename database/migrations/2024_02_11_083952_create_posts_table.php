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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assesment_id');
            $table->datetime('surf_time');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('wave_score_id');
            $table->string('commnet');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('assesment_id')->references('id')->on('assesments');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('wave_score_id')->references('id')->on('wave_scores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
