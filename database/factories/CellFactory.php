<?php

namespace Database\Factories;

use App\Models\Cell;
use Illuminate\Database\Eloquent\Factories\Factory;

class CellFactory extends Factory
{
    protected $model = Cell::class;

    public function definition()
    {
        return [
            'index' => fake()->unique()->randomNumber(),
            'x' => fake()->randomNumber(),
            'y' => fake()->randomNumber(),
            'value' => fake()->numberBetween(0, 8),
            'is_mine' => fake()->boolean,
            'is_flag' => fake()->boolean,
            'is_revealed' => fake()->boolean,
        ];
    }
}
