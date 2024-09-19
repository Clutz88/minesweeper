<?php

namespace Database\Factories;

use App\Models\Cell;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CellFactory extends Factory
{
    protected $model = Cell::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
