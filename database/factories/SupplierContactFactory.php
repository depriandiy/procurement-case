<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\SupplierContact;
use App\Support\SupplierIdentityNormalizer;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SupplierContact> */
class SupplierContactFactory extends Factory
{
    protected $model = SupplierContact::class;

    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'is_primary' => false,
            'is_active' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (SupplierContact $contact) {
            $normalizer = new SupplierIdentityNormalizer;
            $contact->normalized_email = $normalizer->email($contact->email);
            $contact->normalized_phone = $normalizer->phone($contact->phone);
        });
    }
}
