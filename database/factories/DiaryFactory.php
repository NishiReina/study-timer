<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Diary;
use Faker\Provider\DateTime; // 追加

class DiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(10),
            'content' => $this->faker->realText(30),
            'time' => $this->faker->regexify('([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]'),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-30 week', $endDate = 'now')
        ];
    }
}
