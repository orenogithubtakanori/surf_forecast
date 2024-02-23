<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Models\Location;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'id' => 1,
            'name' => '由比ヶ浜',
            'area_id' => 1,
            'shoreline_direction_id' => 11,
            'latitude' => 35.31,
            'longitude' => 139.54,
            'created_at' => new DateTime(),
        ]);
        DB::table('locations')->insert([
            'id' => 2,
            'name' => '七里ヶ浜',
            'area_id' => 1,
            'shoreline_direction_id' => 10,
            'latitude' => 35.31,
            'longitude' => 139.50,
            'created_at' => new DateTime(),
        ]);
        DB::table('locations')->insert([
            'id' => 3,
            'name' => '鵠沼',
            'area_id' => 1,
            'shoreline_direction_id' => 11,
            'latitude' => 35.31,
            'longitude' => 139.47,
            'created_at' => new DateTime(),
        ]);
        DB::table('locations')->insert([
            'id' => 4,
            'name' => '辻堂',
            'area_id' => 1,
            'shoreline_direction_id' => 10,
            'latitude' => 35.32,
            'longitude' => 139.45,
            'created_at' => new DateTime(),
        ]);
        DB::table('locations')->insert([
            'id' => 5,
            'name' => 'チサン',
            'area_id' => 1,
            'shoreline_direction_id' => 9,
            'latitude' => 35.32,
            'longitude' => 139.43,
            'created_at' => new DateTime(),
        ]);
        DB::table('locations')->insert([
            'id' => 6,
            'name' => '平塚',
            'area_id' => 2,
            'shoreline_direction_id' => 9,
            'latitude' => 35.31,
            'longitude' => 139.36,
            'created_at' => new DateTime(),
        ]);
        DB::table('locations')->insert([
            'id' => 7,
            'name' => '大磯',
            'area_id' => 2,
            'shoreline_direction_id' => 8,
            'latitude' => 35.31,
            'longitude' => 139.32,
            'created_at' => new DateTime(),
        ]);
        DB::table('locations')->insert([
            'id' => 8,
            'name' => '吉浜',
            'area_id' => 2,
            'shoreline_direction_id' => 7,
            'latitude' => 35.15,
            'longitude' => 139.12,
            'created_at' => new DateTime(),
        ]);
        //Location::factory()->count(50)->create();
    }
}
