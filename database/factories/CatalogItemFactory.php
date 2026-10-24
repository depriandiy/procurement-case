<?php

namespace Database\Factories;

use App\Models\CatalogItem;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CatalogItem> */
class CatalogItemFactory extends Factory
{
    protected $model = CatalogItem::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('ITEM-####')),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->sentence(),
            'category_id' => Category::factory(),
            'base_unit_id' => Unit::factory(),
            'is_active' => true,
        ];
    }
}
