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
        Schema::create('assesments', function (Blueprint $table) {
            $table->id();
            $table->datetime('datetime');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('surfing_level_id');
            $table->unsignedBigInteger('wave_score_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('surfing_level_id')->references('id')->on('surfing_levels');
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
        Schema::dropIfExists('assesments');
    }
};
