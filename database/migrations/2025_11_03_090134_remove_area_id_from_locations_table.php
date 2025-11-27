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
        // 外部キー制約が存在する場合のみ削除
        try {
            Schema::table('locations', function (Blueprint $table) {
                $table->dropForeign(['area_id']);
            });
        } catch (\Exception $e) {
            // 外部キー制約が存在しない場合はスキップ
        }
        
        // area_idカラムが存在する場合のみ削除
        if (Schema::hasColumn('locations', 'area_id')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->dropColumn('area_id');
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
        Schema::table('locations', function (Blueprint $table) {
            $table->foreignId('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }
};
