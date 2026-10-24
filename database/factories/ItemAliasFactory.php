<?php

namespace Database\Factories;

use App\Models\CatalogItem;
use App\Models\ItemAlias;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<ItemAlias> */
class ItemAliasFactory extends Factory
{
    protected $model = ItemAlias::class;

    public function definition(): array
    {
        $alias = fake()->unique()->words(3, true);

        return [
            'supplier_id' => Supplier::factory(),
            'catalog_item_id' => CatalogItem::factory(),
            'alias' => Str::title($alias),
            'normalized_alias' => Str::lower($alias),
            'raw_unit' => 'pcs',
            'normalized_unit' => 'PCS',
            'conversion_factor' => 1,
            'is_active' => true,
        ];
    }
}
