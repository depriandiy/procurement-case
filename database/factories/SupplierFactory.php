<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Support\SupplierIdentityNormalizer;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Supplier> */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'tax_id' => null,
            'address' => fake()->optional()->address(),
            'city' => fake()->optional()->city(),
            'review_status' => 'pending',
            'is_active' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Supplier $supplier) {
            $normalizer = new SupplierIdentityNormalizer;
            $supplier->normalized_name = $normalizer->companyName($supplier->name);
            $supplier->normalized_tax_id = $normalizer->taxId($supplier->tax_id);
        });
    }
}
