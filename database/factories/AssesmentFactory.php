<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Assesment; // モデルの名前空間を適切に指定

class AssesmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assesment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'datetime' => $this->faker->dateTimeThisYear,
            'location_id' => $this->faker->randomDigitNotNull,
            'surfing_level_id' => $this->faker->numberBetween($min=1,$max=3),
            'wave_score_id' => $this->faker->numberBetween($min=1,$max=5)
        ];
    }
}