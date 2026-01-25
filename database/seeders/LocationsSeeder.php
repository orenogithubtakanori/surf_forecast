<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use DateTime;
use App\Models\Location;
use App\Models\Prefecture;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 既存のレコードを全て削除（外部キー制約を一時的に無効化）
        Schema::disableForeignKeyConstraints();
        DB::table('locations')->truncate();
        Schema::enableForeignKeyConstraints();
        
        // 神奈川県のIDを取得（シーダーの実行順序により、存在する前提）
        $kanagawa = Prefecture::where('name', '神奈川県（湘南・西湘）')->first();
        if (!$kanagawa) {
            return; // 都道府県が存在しない場合はスキップ
        }
        
        $prefectureId = $kanagawa->id;
        
        // 新しいデータ
        $locationsData = [
            ['id' => 1, 'name' => '由比ヶ浜', 'city' => '鎌倉市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 11, 'latitude' => 35.31, 'longitude' => 139.54, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 2, 'name' => '稲村ヶ崎', 'city' => '鎌倉市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 10, 'latitude' => 35.3, 'longitude' => 139.52, 'landscape' => 'リーフ', 'parking' => true],
            ['id' => 3, 'name' => '七里ヶ浜', 'city' => '鎌倉市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 10, 'latitude' => 35.3040108941274, 'longitude' => 139.513618634792, 'landscape' => 'リーフ', 'parking' => true],
            ['id' => 4, 'name' => '鎌倉高校前', 'city' => '鎌倉市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 10, 'latitude' => 35.3061729984588, 'longitude' => 139.500965564496, 'landscape' => 'リーフ', 'parking' => false],
            ['id' => 5, 'name' => '江ノ島水族館前', 'city' => '藤沢市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 11, 'latitude' => 35.3095422263488, 'longitude' => 139.479225505792, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 6, 'name' => '鵠沼', 'city' => '藤沢市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 10, 'latitude' => 35.3141526887314, 'longitude' => 139.471137168607, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 7, 'name' => 'スケパー前', 'city' => '藤沢市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 10, 'latitude' => 35.3155721208172, 'longitude' => 139.466326674394, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 8, 'name' => '松浪地下道前', 'city' => '藤沢市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 10, 'latitude' => 35.3166359548238, 'longitude' => 139.4617507483, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 9, 'name' => '湘洋中学校前', 'city' => '藤沢市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 10, 'latitude' => 35.3173594971719, 'longitude' => 139.458172771493, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 10, 'name' => '辻堂', 'city' => '藤沢市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 9, 'latitude' => 35.318067044796, 'longitude' => 139.453158346649, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 11, 'name' => '第2駐車場前', 'city' => '藤沢市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 9, 'latitude' => 35.3191524445557, 'longitude' => 139.44404227339, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 12, 'name' => 'クソ下', 'city' => '茅ヶ崎市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 9, 'latitude' => 35.3191562616448, 'longitude' => 139.436066789831, 'landscape' => 'ビーチ', 'parking' => false],
            ['id' => 13, 'name' => 'チサン', 'city' => '茅ヶ崎市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 9, 'latitude' => 35.3190915466493, 'longitude' => 139.430190937438, 'landscape' => 'ビーチ', 'parking' => false],
            ['id' => 14, 'name' => 'チーパー', 'city' => '茅ヶ崎市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 8, 'latitude' => 35.318202794778, 'longitude' => 139.423383311166, 'landscape' => 'ビーチ', 'parking' => false],
            ['id' => 15, 'name' => 'パーク', 'city' => '茅ヶ崎市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 8, 'latitude' => 35.3168950933754, 'longitude' => 139.416922364256, 'landscape' => 'ビーチ', 'parking' => false],
            ['id' => 16, 'name' => '裏パーク', 'city' => '茅ヶ崎市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 11, 'latitude' => 35.3166126279074, 'longitude' => 139.413277515452, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 17, 'name' => '白樺', 'city' => '茅ヶ崎市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 9, 'latitude' => 35.3178414898728, 'longitude' => 139.406996699361, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 18, 'name' => 'サザンビーチ', 'city' => '茅ヶ崎市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 8, 'latitude' => 35.3170665209062, 'longitude' => 139.400656591399, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 19, 'name' => '西浜', 'city' => '茅ヶ崎市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 10, 'latitude' => 35.3161213749394, 'longitude' => 139.394498110537, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 20, 'name' => '生コン前', 'city' => '平塚市', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 9, 'latitude' => 35.3147669192637, 'longitude' => 139.361948629708, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 21, 'name' => '大磯', 'city' => '大磯町', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 8, 'latitude' => 35.309642041091, 'longitude' => 139.320725540601, 'landscape' => 'ビーチ', 'parking' => true],
            ['id' => 22, 'name' => '吉浜', 'city' => '湯河原町', 'prefecture_id' => $prefectureId, 'shoreline_direction_id' => 7, 'latitude' => 35.1490562127512, 'longitude' => 139.120418349073, 'landscape' => 'ビーチ', 'parking' => true],
        ];
        
        foreach ($locationsData as $locationData) {
            DB::table('locations')->insert([
                'id' => $locationData['id'],
                'name' => $locationData['name'],
                'city' => $locationData['city'],
                'prefecture_id' => $locationData['prefecture_id'],
                'shoreline_direction_id' => $locationData['shoreline_direction_id'],
                'latitude' => $locationData['latitude'],
                'longitude' => $locationData['longitude'],
                'landscape' => $locationData['landscape'],
                'parking' => $locationData['parking'],
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
