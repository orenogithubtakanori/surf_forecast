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
            'arrow_deg' => 0,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 2,
            'direction' => 'NNE',
            'created_at' => new DateTime(),
            'arrow_deg' => 23,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 3,
            'direction' => 'NE',
            'created_at' => new DateTime(),
            'arrow_deg' => 45,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 4,
            'direction' => 'ENE',
            'created_at' => new DateTime(),
            'arrow_deg' => 67,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 5,
            'direction' => 'E',
            'created_at' => new DateTime(),
            'arrow_deg' => 90,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 6,
            'direction' => 'ESE',
            'created_at' => new DateTime(),
            'arrow_deg' => 113,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 7,
            'direction' => 'SE',
            'created_at' => new DateTime(),
            'arrow_deg' => 135,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 8,
            'direction' => 'SSE',
            'created_at' => new DateTime(),
            'arrow_deg' => 157,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 9,
            'direction' => 'S',
            'created_at' => new DateTime(),
            'arrow_deg' => 180,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 10,
            'direction' => 'SSW',
            'created_at' => new DateTime(),
            'arrow_deg' => 203,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 11,
            'direction' => 'SW',
            'created_at' => new DateTime(),
            'arrow_deg' => 225,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 12,
            'direction' => 'WSW',
            'created_at' => new DateTime(),
            'arrow_deg' => 247,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 13,
            'direction' => 'W',
            'created_at' => new DateTime(),
            'arrow_deg' => 270,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 14,
            'direction' => 'WNW',
            'created_at' => new DateTime(),
            'arrow_deg' => 293,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 15,
            'direction' => 'NW',
            'created_at' => new DateTime(),
            'arrow_deg' => 315,
        ]);
        DB::table('shoreline_directions')->insert([
            'id' => 16,
            'direction' => 'NNW',
            'created_at' => new DateTime(),
            'arrow_deg' => 337,
        ]);
    }
}
