<?php

namespace Database\Factories;

use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Submission> */
class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition(): array
    {
        return [
            'reference_no' => fake()->unique()->numerify('KDI-########'),
            'supplier_id' => null,
            'contact_id' => null,
            'revision_no' => 1,
            'status' => 'submitted',
            'submitted_at' => now(),
            'valid_until' => now()->addDays(fake()->numberBetween(7, 60))->toDateString(),
            'currency' => 'IDR',
            'verification_code' => hash('sha256', fake()->uuid()),
            'supplier_name' => fake()->company(),
            'supplier_tax_id' => null,
            'supplier_address' => fake()->address(),
            'contact_name' => fake()->name(),
            'contact_email' => fake()->safeEmail(),
            'contact_phone' => fake()->phoneNumber(),
        ];
    }
}
