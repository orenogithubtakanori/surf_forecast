<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        $this->call(Shoreline_DirectionsSeeder::class);
        $this->call(AreasSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(ConditionsSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(Surfing_LevelsSeeder::class);
        $this->call(Wave_ScoresSeeder::class);
        $this->call(ScoresSeeder::class);
    }
}
