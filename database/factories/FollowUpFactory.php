<?php

namespace Database\Factories;

use App\Models\FollowUp;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<FollowUp> */
class FollowUpFactory extends Factory
{
    protected $model = FollowUp::class;

    public function definition(): array
    {
        return [
            'submission_id' => Submission::factory(),
            'user_id' => null,
            'type' => 'note',
            'body' => fake()->sentence(),
            'due_at' => null,
            'completed_at' => null,
        ];
    }
}
