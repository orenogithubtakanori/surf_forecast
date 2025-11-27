<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Condition;
use App\Models\Location;
use App\Models\Score;
use App\Models\Surfing_Level;
use Carbon\Carbon;

class ScoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private function getScore($waveHeight, $surfingLevel)
    {
        switch ($surfingLevel) {
            case 3:
                if ($waveHeight >= 0.0 && $waveHeight < 0.2) {
                    return 1;
                } elseif ($waveHeight >= 0.2 && $waveHeight < 0.5) {
                    return 2;
                } elseif ($waveHeight >= 0.5 && $waveHeight < 0.8) {
                    return 3;
                } elseif ($waveHeight >= 0.8 && $waveHeight < 1) {
                    return 4;
                } else {
                    return 5;
                }
                break;
            case 2:
                if ($waveHeight >= 0.0 && $waveHeight < 0.3) {
                    return 1;
                } elseif ($waveHeight >= 0.3 && $waveHeight < 0.6) {
                    return 2;
                } elseif ($waveHeight >= 0.6 && $waveHeight < 0.9) {
                    return 3;
                } elseif ($waveHeight >= 0.9 && $waveHeight < 1.1) {
                    return 4;
                } else {
                    return 5;
                }
                break;
            case 1:
                if ($waveHeight >= 0.0 && $waveHeight < 0.4) {
                    return 1;
                } elseif ($waveHeight >= 0.4 && $waveHeight < 0.7) {
                    return 2;
                } elseif ($waveHeight >= 0.7 && $waveHeight < 1) {
                    return 3;
                } elseif ($waveHeight >= 1 && $waveHeight < 1.2) {
                    return 4;
                } else {
                    return 5;
                }
                break;
            default:
                return 1;
        }
    }
     public function run()
    {
        $conditions = Condition::all();
        $surfingLevels = Surfing_Level::all();

        // Conditionテーブルにデータがある場合のみ処理
        if ($conditions->isNotEmpty() && $surfingLevels->isNotEmpty()) {
            foreach($conditions as $condition){
                foreach($surfingLevels as $surfingLevel){
                    $score = $this->getScore($condition->wave_height, $surfingLevel->id);
                    Score::create([
                        'score' => $score,
                        'surfing_level_id' => $surfingLevel->id,
                        'location_id' => $condition->location_id,
                        'datetime' => $condition->date,
                        'wave_height' => $condition->wave_height,
                        'wave_direction' => $condition->wave_direction,
                        'wind_speed' => $condition->wind_speed,
                        'wind_direction' => $condition->wind_direction,
                        'weather' => $condition->weather ?? '晴れ',
                        'temperature' => $condition->temperature,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        // 2025/11/15から2026/1/31までのダミーデータを生成
        $this->generateDummyData();
    }
    
    /**
     * 2025/11/15から2026/1/31までのダミーデータを生成
     */
    private function generateDummyData()
    {
        $locations = Location::all();
        $surfingLevels = Surfing_Level::all();
        
        if ($locations->isEmpty() || $surfingLevels->isEmpty()) {
            $this->command->warn('Locations or Surfing_Levels not found. Skipping dummy data generation.');
            return;
        }
        
        // 16方位
        $directions = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
        
        // 天気パターン
        $weathers = ['晴れ', '曇り', '雨', '晴れのち曇り'];
        
        $startDate = Carbon::parse('2025-11-15');
        $endDate = Carbon::parse('2026-01-31');
        
        // 1日毎時（0時から23時まで）のデータを生成
        $hours = range(0, 23);
        
        $currentDate = $startDate->copy();
        $dataCount = 0;
        $batch = [];
        $batchSize = 500; // バッチサイズ
        
        while ($currentDate->lte($endDate)) {
            // 日付ごとに既存データを取得（メモリ効率化）
            $dayStart = $currentDate->copy()->startOfDay();
            $dayEnd = $currentDate->copy()->endOfDay();
            $existingScores = Score::whereBetween('datetime', [$dayStart, $dayEnd])
                ->get(['location_id', 'surfing_level_id', 'datetime'])
                ->map(function($score) {
                    $datetime = is_string($score->datetime) ? Carbon::parse($score->datetime) : $score->datetime;
                    return $score->location_id . '_' . $score->surfing_level_id . '_' . $datetime->format('Y-m-d H:i:s');
                })
                ->toArray();
            
            foreach ($locations as $location) {
                foreach ($surfingLevels as $surfingLevel) {
                    foreach ($hours as $hour) {
                        $datetime = $currentDate->copy()->setTime($hour, 0, 0);
                        $key = $location->id . '_' . $surfingLevel->id . '_' . $datetime->format('Y-m-d H:i:s');
                        
                        // 既存データのチェック（重複を避ける）
                        if (in_array($key, $existingScores)) {
                            continue; // 既に存在する場合はスキップ
                        }
                        
                        // ランダムな値を生成（現実的な範囲で）
                        $waveHeight = round(mt_rand(20, 200) / 100, 1); // 0.2m ~ 2.0m
                        $windSpeed = round(mt_rand(10, 150) / 10, 1); // 1.0m/s ~ 15.0m/s
                        $temperature = mt_rand(5, 25); // 5℃ ~ 25℃
                        
                        $waveDirection = $directions[array_rand($directions)];
                        $windDirection = $directions[array_rand($directions)];
                        $weather = $weathers[array_rand($weathers)];
                        
                        $score = $this->getScore($waveHeight, $surfingLevel->id);
                        
                        $batch[] = [
                            'score' => $score,
                            'surfing_level_id' => $surfingLevel->id,
                            'location_id' => $location->id,
                            'datetime' => $datetime,
                            'wave_height' => $waveHeight,
                            'wave_direction' => $waveDirection,
                            'wind_speed' => $windSpeed,
                            'wind_direction' => $windDirection,
                            'weather' => $weather,
                            'temperature' => $temperature,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        
                        $dataCount++;
                        
                        // バッチサイズに達したら一括挿入
                        if (count($batch) >= $batchSize) {
                            Score::insert($batch);
                            $batch = [];
                            $this->command->info("Inserted batch. Total records: {$dataCount}");
                            // メモリを解放
                            if (function_exists('gc_collect_cycles')) {
                                gc_collect_cycles();
                            }
                        }
                    }
                }
            }
            
            // 日付ごとにメモリを解放
            unset($existingScores);
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
            
            $currentDate->addDay();
        }
        
        // 残りのデータを挿入
        if (!empty($batch)) {
            Score::insert($batch);
        }
        
        $this->command->info("Generated {$dataCount} dummy score records from 2025-11-15 to 2026-01-31");
    }
}
