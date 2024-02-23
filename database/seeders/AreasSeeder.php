<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Models\Area;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'id' => 1,
            'name' => '湘南',
            'prefecture_name' => '神奈川',
            'region_name' => '関東',
            'created_at' => new DateTime(),
        ]);

        DB::table('areas')->insert([
            'id' => 2,
            'name' => '西湘',
            'prefecture_name' => '神奈川',
            'region_name' => '関東',
            'created_at' => new DateTime(),
        ]);

        //Area::factory()->count(50)->create();
        
    }
}
