<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // 神奈川県のIDを取得（シーダーの実行順序により、存在する前提）
        $kanagawa = Prefecture::where('name', '神奈川県（湘南・西湘）')->first();
        if (!$kanagawa) {
            return; // 都道府県が存在しない場合はスキップ
        }
        
        $prefectureId = $kanagawa->id;
        
        // 市区町村のマッピング
        $locationsData = [
            ['id' => 1, 'name' => '由比ヶ浜', 'city' => '鎌倉市', 'shoreline_direction_id' => 11, 'latitude' => 35.31, 'longitude' => 139.54],
            ['id' => 2, 'name' => '七里ヶ浜', 'city' => '鎌倉市', 'shoreline_direction_id' => 10, 'latitude' => 35.31, 'longitude' => 139.50],
            ['id' => 3, 'name' => '鵠沼', 'city' => '藤沢市', 'shoreline_direction_id' => 11, 'latitude' => 35.31, 'longitude' => 139.47],
            ['id' => 4, 'name' => '辻堂', 'city' => '藤沢市', 'shoreline_direction_id' => 10, 'latitude' => 35.32, 'longitude' => 139.45],
            ['id' => 5, 'name' => 'チサン', 'city' => '茅ヶ崎市', 'shoreline_direction_id' => 9, 'latitude' => 35.32, 'longitude' => 139.43],
            ['id' => 6, 'name' => '平塚', 'city' => '平塚市', 'shoreline_direction_id' => 9, 'latitude' => 35.31, 'longitude' => 139.36],
            ['id' => 7, 'name' => '大磯', 'city' => '大磯町', 'shoreline_direction_id' => 8, 'latitude' => 35.31, 'longitude' => 139.32],
            ['id' => 8, 'name' => '吉浜', 'city' => '湯河原町', 'shoreline_direction_id' => 7, 'latitude' => 35.15, 'longitude' => 139.12],
        ];
        
        foreach ($locationsData as $locationData) {
            $existing = DB::table('locations')->where('id', $locationData['id'])->first();
            
            if ($existing) {
                // 既存のレコードを更新
                DB::table('locations')->where('id', $locationData['id'])->update([
                    'city' => $locationData['city'],
                    'prefecture_id' => $prefectureId,
                    'shoreline_direction_id' => $locationData['shoreline_direction_id'],
                    'latitude' => $locationData['latitude'],
                    'longitude' => $locationData['longitude'],
                ]);
            } else {
                // 新規レコードを挿入
                DB::table('locations')->insert([
                    'id' => $locationData['id'],
                    'name' => $locationData['name'],
                    'city' => $locationData['city'],
                    'prefecture_id' => $prefectureId,
                    'shoreline_direction_id' => $locationData['shoreline_direction_id'],
                    'latitude' => $locationData['latitude'],
                    'longitude' => $locationData['longitude'],
                    'created_at' => new DateTime(),
                ]);
            }
        }
        //Location::factory()->count(50)->create();
    }
}
