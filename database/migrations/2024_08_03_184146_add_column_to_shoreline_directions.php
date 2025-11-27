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
        // arrow_degカラムが既に存在する場合はスキップ
        if (!Schema::hasColumn('shoreline_directions', 'arrow_deg')) {
            Schema::table('shoreline_directions', function (Blueprint $table) {
                $table->unsignedBigInteger('arrow_deg');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shoreline_directions', function (Blueprint $table) {
            //
        });
    }
};
