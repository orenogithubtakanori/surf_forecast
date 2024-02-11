<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Models\Shoreline_Direction;

class Shoreline_DirectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shoreline_directions')->insert([
            'direction' => '南南東',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '南東',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '東南東',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '東',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '東北東',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '北東',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '北北東',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '北',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '北北西',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '北西',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '西北西',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '西',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '西南西',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '南西',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'direction' => '南南西',
            'created_at' => new DateTime(),
        ]);
    }
}
