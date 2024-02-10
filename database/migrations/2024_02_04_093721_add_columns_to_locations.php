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
        Schema::table('locations', function (Blueprint $table) {
            //$table->unsignedBigInteger('area_id');
            //$table->unsignedBigInteger('shoreline_direction_id');

            // Foreign key constraint
            $table->foreignId('area_id')->references('id')->on('areas');
            $table->foreignId('shoreline_direction_id')->references('id')->on('shoreline_directions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            //
        });
    }
};
