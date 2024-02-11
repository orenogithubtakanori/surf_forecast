<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Models\Surfing_Level;

class Surfing_LevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('surfing_levels')->insert([
            'level' => '上級者',
            'created_at' => new DateTime(),
        ]);
        DB::table('surfing_levels')->insert([
            'level' => '中級者',
            'created_at' => new DateTime(),
        ]);
        DB::table('surfing_levels')->insert([
            'level' => '初級者',
            'created_at' => new DateTime(),
        ]);
    }
}
