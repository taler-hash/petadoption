<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class AnimalFactory extends Factory
{
    protected $model = Animal::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['cat', 'dog']),
            'name' => $this->faker->name,
            'description' => $this->faker->word,
            'breed' => $this->faker->word,
            'age' => $this->faker->numberBetween(1, 10),
            'image' => "/animals/".$this->faker->image('public/storage/animals', 400, 400, null, false), // Fake image
            'status' => $this->faker->randomElement(['available', 'adopted']),
        ];
    }
}

