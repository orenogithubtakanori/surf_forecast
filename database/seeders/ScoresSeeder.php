<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Condition;
use App\Models\Location;
use App\Models\Score;
use App\Models\Surfing_Level;

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

        foreach($conditions as $condition){
            //foreach($surfingLevels as $surfingLevel){
                //$score = $this->getScore($condition->wave_height,$surfingLevel->id);
                Score::create([
                    //'score' => $score,
                    //'surfing_level_id' => $surfingLevel->id,
                    'location_id' => $condition->location_id,
                    'datetime' => $condition->date,
                    'wave_height' => $condition->wave_height,
                    'wave_direction' => $condition->wave_direction,
                    'wind_speed' => $condition->wind_speed,
                    'wind_direction' => $condition->wind_direction,
                    'temperature' => $condition->temperature,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            //}
        }
    }
}
