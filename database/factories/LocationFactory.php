<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Location; // モデルの名前空間を適切に指定

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'area_id' => $this->faker->numberBetween($min=1,$max=50),
            'shoreline_direction_id' => $this->faker->numberBetween($min=1,$max=16)
        ];
    }
}