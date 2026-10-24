<?php

namespace Database\Factories;

use App\Models\Submission;
use App\Models\SubmissionSupplierLinkHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SubmissionSupplierLinkHistory> */
class SubmissionSupplierLinkHistoryFactory extends Factory
{
    protected $model = SubmissionSupplierLinkHistory::class;

    public function definition(): array
    {
        return [
            'submission_id' => Submission::factory(),
            'from_supplier_id' => null,
            'to_supplier_id' => null,
            'changed_by' => null,
            'reason' => fake()->optional()->sentence(),
        ];
    }
}
