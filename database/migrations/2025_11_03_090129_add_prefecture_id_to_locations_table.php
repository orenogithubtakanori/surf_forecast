<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // このマイグレーションは既にcreate_prefectures_table内で処理されているため、
        // このファイルは空にするか、または処理が重複しないようにする
        // ただし、マイグレーションの実行順序を考慮すると、
        // create_prefectures_tableが先に実行されるため、
        // このマイグレーションではprefecture_idは既に追加されている
        // そのため、このマイグレーションは空または最小限の処理のみ
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['prefecture_id']);
            $table->dropColumn('prefecture_id');
        });
    }
};
