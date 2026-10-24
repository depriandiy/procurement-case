<?php

namespace Database\Factories;

use App\Models\Submission;
use App\Models\SubmissionStatusHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SubmissionStatusHistory> */
class SubmissionStatusHistoryFactory extends Factory
{
    protected $model = SubmissionStatusHistory::class;

    public function definition(): array
    {
        return [
            'submission_id' => Submission::factory(),
            'from_status' => 'submitted',
            'to_status' => 'under_review',
            'changed_by' => null,
            'note' => fake()->optional()->sentence(),
        ];
    }
}
