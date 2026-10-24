<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Unit> */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        $code = strtolower(fake()->unique()->bothify('u-####'));

        return [
            'code' => $code,
            'name' => fake()->unique()->words(2, true),
            'symbol' => $code,
            'dimension' => fake()->randomElement(['mass', 'volume', 'count']),
            'is_active' => true,
        ];
    }
}
