<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post; // モデルの名前空間を適切に指定

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
            'assesment_id' => $this->faker->numberBetween($min=4,$max=53),
            'surf_time'=> $this->faker->dateTimeThisYear,
            'wave_score_id' => $this->faker->numberBetween($min=1,$max=5),
            'comment' => $this->faker->text
        ];
    }
}