<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Models\Prefecture;

class PrefecturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 既にデータが存在する場合はスキップ
        if (Prefecture::where('name', '神奈川県（湘南・西湘）')->exists()) {
            return;
        }
        
        Prefecture::create([
            'name' => '神奈川県（湘南・西湘）',
        ]);
    }
}
