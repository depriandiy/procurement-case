<?php

namespace Database\Factories;

use App\Models\SubmissionItem;
use App\Models\SubmissionItemMappingHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SubmissionItemMappingHistory> */
class SubmissionItemMappingHistoryFactory extends Factory
{
    protected $model = SubmissionItemMappingHistory::class;

    public function definition(): array
    {
        return [
            'submission_item_id' => SubmissionItem::factory(),
            'from_catalog_item_id' => null,
            'to_catalog_item_id' => null,
            'from_unit_id' => null,
            'to_unit_id' => null,
            'conversion_factor' => 1,
            'changed_by' => null,
            'note' => fake()->optional()->sentence(),
        ];
    }
}
