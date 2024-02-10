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
        Schema::create('conditions', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->date('date');
            $table->unsignedBigInteger('location_id');
            $table->float('wave_height');
            $table->string('wave_direction');
            $table->float('wind_speed');
            $table->string('wind_direction');
            $table->string('weather');
            $table->float('temperature');
            $table->integer('tide');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conditions');
    }
};
