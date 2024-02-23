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
            'id' => 1,
            'direction' => 'N',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 2,
            'direction' => 'NNE',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 3,
            'direction' => 'NE',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 4,
            'direction' => 'ENE',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 5,
            'direction' => 'E',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 6,
            'direction' => 'ESE',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 7,
            'direction' => 'SE',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 8,
            'direction' => 'SSE',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 9,
            'direction' => 'S',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 10,
            'direction' => 'SSW',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 11,
            'direction' => 'SW',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 12,
            'direction' => 'WSW',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 13,
            'direction' => 'W',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 14,
            'direction' => 'WNW',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 15,
            'direction' => 'NW',
            'created_at' => new DateTime(),
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 16,
            'direction' => 'NNW',
            'created_at' => new DateTime(),
        ]);
    }
}
