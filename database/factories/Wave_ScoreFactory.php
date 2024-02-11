<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Wave_Score; // モデルの名前空間を適切に指定

class Wave_ScoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wave_Score::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'wave_score' => $this->faker->numberBetween($min=1,$max=5),
            'surfing_level_id' => $this->faker->numberBetween($min=1,$max=3),
            'wave_score_name' => $this->faker->sentence()
        ];
    }
}