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
        Schema::create('wave_scores', function (Blueprint $table) {
            $table->id();
            $table->integer('wave_score');
            $table->unsignedBigInteger('surfing_level_id');
            $table->string('wave_score_name');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('surfing_level_id')->references('id')->on('surfing_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wave_scores');
    }
};
