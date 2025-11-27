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
        // areasテーブルは既にprefecturesテーブルにリネームされているため、削除不要
        // このマイグレーションは空にする
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('prefecture_name')->nullable(false);
            $table->string('region_name')->nullable(false);
            $table->string('country')->default('日本');
            $table->timestamps();
        });
    }
};
