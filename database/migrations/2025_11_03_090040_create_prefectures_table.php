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
        // locationsテーブルにprefecture_idカラムを追加（既に存在する場合はスキップ）
        if (!Schema::hasColumn('locations', 'prefecture_id')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->foreignId('prefecture_id')->nullable()->after('area_id');
            });
        }
        
        // areasテーブルをprefecturesテーブルにリネーム（既にリネームされている場合はスキップ）
        if (Schema::hasTable('areas')) {
            Schema::rename('areas', 'prefectures');
        }
        
        // 元のnameカラム（エリア名）を一時的に別名に変更してから削除
        // または、直接削除
        if (Schema::hasColumn('prefectures', 'name')) {
            Schema::table('prefectures', function (Blueprint $table) {
                $table->dropColumn('name'); // 元のnameカラム（エリア名）を削除
            });
        }
        
        // prefecture_nameカラムをnameにリネーム（既にリネームされている場合はスキップ）
        if (Schema::hasColumn('prefectures', 'prefecture_name')) {
            DB::statement('ALTER TABLE prefectures CHANGE COLUMN prefecture_name name VARCHAR(255) NOT NULL');
        }
        
        // region_nameカラムが存在する場合は削除
        if (Schema::hasColumn('prefectures', 'region_name')) {
            Schema::table('prefectures', function (Blueprint $table) {
                $table->dropColumn('region_name');
            });
        }
        
        // countryカラムが存在する場合は削除
        if (Schema::hasColumn('prefectures', 'country')) {
            Schema::table('prefectures', function (Blueprint $table) {
                $table->dropColumn('country');
            });
        }
        
        // locationsテーブルのarea_idからprefecture_idを設定
        // 統合前にマッピングを作成（元のareasテーブルのidがそのまま残っている間）
        $locations = DB::table('locations')->get();
        foreach ($locations as $location) {
            if ($location->area_id) {
                // 元のareasテーブル（現在はprefecturesテーブル）からarea_idに対応するレコードを取得
                $prefectureRecord = DB::table('prefectures')->where('id', $location->area_id)->first();
                if ($prefectureRecord) {
                    // この時点では、元のareasテーブルのidがそのまま残っている
                    // ただし、同じ都道府県名のレコードが複数ある場合は統合が必要
                    // そのため、まずは元のidを一時的にprefecture_idに設定
                    DB::table('locations')
                        ->where('id', $location->id)
                        ->update(['prefecture_id' => $location->area_id]);
                }
            }
        }
        
        // 重複する都道府県名のレコードを統合
        // ただし、locationsテーブルのarea_idが外部キー制約で参照しているため、
        // 削除する前にarea_idの外部キー制約を一時的に削除する必要がある
        // 外部キー制約が存在する場合のみ削除
        try {
            Schema::table('locations', function (Blueprint $table) {
                $table->dropForeign(['area_id']);
            });
        } catch (\Exception $e) {
            // 外部キー制約が存在しない場合はスキップ
        }
        
        // prefecturesテーブルに必要なカラムが存在するか確認
        // カラムが不足している場合は、マイグレーションをスキップ
        $hasData = Schema::hasColumn('prefectures', 'name') || Schema::hasColumn('prefectures', 'prefecture_name');
        
        if (!$hasData) {
            // カラムが存在しない場合は、マイグレーションをスキップ
            // これは既に処理が完了しているか、またはデータが失われた可能性がある
            return;
        }
        
        // カラム名を確認（prefecture_nameまたはname）
        $columnName = Schema::hasColumn('prefectures', 'name') ? 'name' : 'prefecture_name';
        
        $prefectureNames = DB::table('prefectures')
            ->select($columnName)
            ->distinct()
            ->pluck($columnName);
        
        $prefectureIdMap = []; // 元のareasテーブルのidから統合後のprefecture_idへのマッピング
        foreach ($prefectureNames as $prefectureName) {
            $prefectures = DB::table('prefectures')->where($columnName, $prefectureName)->get();
            if ($prefectures->count() > 1) {
                // 最初のレコードのidを保持
                $firstId = $prefectures->first()->id;
                
                // 残りのレコードを処理
                foreach ($prefectures as $prefecture) {
                    if ($prefecture->id != $firstId) {
                        // locationsテーブルのprefecture_idとarea_idを更新
                        DB::table('locations')
                            ->where('prefecture_id', $prefecture->id)
                            ->update(['prefecture_id' => $firstId]);
                        
                        DB::table('locations')
                            ->where('area_id', $prefecture->id)
                            ->update(['area_id' => $firstId]);
                        
                        // prefecturesテーブルのレコードを削除
                        DB::table('prefectures')->where('id', $prefecture->id)->delete();
                    }
                }
            }
        }
        
        // prefecture_idをNOT NULLに設定し、外部キー制約を追加
        DB::statement('ALTER TABLE locations MODIFY prefecture_id BIGINT UNSIGNED NOT NULL');
        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('prefecture_id')->references('id')->on('prefectures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // nameカラムをprefecture_nameに戻す
        DB::statement('ALTER TABLE prefectures CHANGE COLUMN name prefecture_name VARCHAR(255) NOT NULL');
        
        // カラムを復元
        Schema::table('prefectures', function (Blueprint $table) {
            $table->string('name')->nullable(false)->after('id');
            $table->string('region_name')->nullable(false)->after('prefecture_name');
            $table->string('country')->default('日本')->after('region_name');
        });
        
        // prefecturesテーブルをareasテーブルにリネーム
        Schema::rename('prefectures', 'areas');
    }
};
