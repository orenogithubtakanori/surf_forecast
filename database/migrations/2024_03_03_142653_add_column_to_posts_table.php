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
        // location_idカラムが既に存在する場合はスキップ
        if (!Schema::hasColumn('posts', 'location_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->unsignedBigInteger('location_id');
                // Foreign key constraint
                $table->foreign('location_id')->references('id')->on('locations');
            });
        } else {
            // カラムは存在するが、外部キー制約がない場合は追加
            try {
                Schema::table('posts', function (Blueprint $table) {
                    $table->foreign('location_id')->references('id')->on('locations');
                });
            } catch (\Exception $e) {
                // 外部キー制約が既に存在する場合はスキップ
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
