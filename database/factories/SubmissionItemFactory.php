<?php

namespace Database\Factories;

use App\Models\Submission;
use App\Models\SubmissionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SubmissionItem> */
class SubmissionItemFactory extends Factory
{
    protected $model = SubmissionItem::class;

    public function definition(): array
    {
        $includesTax = fake()->boolean();

        return [
            'submission_id' => Submission::factory(),
            'line_no' => 1,
            'catalog_item_id' => null,
            'base_unit_id' => null,
            'raw_item_name' => fake()->words(3, true),
            'raw_unit' => fake()->randomElement(['kg', 'dus', 'pcs', 'liter']),
            'offered_price' => fake()->randomFloat(4, 1000, 10000000),
            'price_includes_tax' => $includesTax,
            'tax_rate' => $includesTax ? '11.00' : '0.00',
            'conversion_factor' => null,
            'price_excl_tax' => null,
            'normalized_unit_price' => null,
            'moq' => fake()->randomFloat(4, 1, 100),
            'lead_time_days' => fake()->numberBetween(1, 30),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
