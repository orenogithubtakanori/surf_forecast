<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Models\Condition;

class ConditionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conditions')->insert([
            'date' => new datetime(),
            'location_id' => 1,
            'wave_height' => 1.0,
            'wave_direction' => '南西',
            'wind_speed' => 1.0,
            'wind_direction' => '北東',
            'weather' => '晴れ',
            'temperature' => 20,
            'tide' => 100,
            'temperature' => 24.5,
            'created_at' => new DateTime(),
            
        ]);
    }
}
