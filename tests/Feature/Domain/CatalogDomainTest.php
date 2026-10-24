<?php

namespace Tests\Feature\Domain;

use App\Models\CatalogItem;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CatalogDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_schema_stores_units_categories_and_items(): void
    {
        $this->assertTrue(Schema::hasColumns('units', [
            'code',
            'name',
            'symbol',
            'dimension',
            'is_active',
        ]));

        $this->assertTrue(Schema::hasColumns('categories', [
            'name',
            'slug',
            'is_active',
        ]));

        $this->assertTrue(Schema::hasColumns('catalog_items', [
            'code',
            'name',
            'description',
            'category_id',
            'base_unit_id',
            'is_active',
        ]));
    }

    public function test_catalog_item_belongs_to_a_category_and_base_unit(): void
    {
        $unit = Unit::query()->create([
            'code' => 'kg',
            'name' => 'Kilogram',
            'symbol' => 'kg',
            'dimension' => 'mass',
        ]);
        $category = Category::query()->create([
            'name' => 'Bahan Baku',
            'slug' => 'bahan-baku',
        ]);
        $item = CatalogItem::query()->create([
            'code' => 'BERAS-001',
            'name' => 'Beras Premium',
            'category_id' => $category->id,
            'base_unit_id' => $unit->id,
        ]);

        $this->assertTrue($item->category->is($category));
        $this->assertTrue($item->baseUnit->is($unit));
        $this->assertTrue($category->catalogItems->contains($item));
        $this->assertTrue($unit->catalogItems->contains($item));
        $this->assertTrue($category->is_active);
        $this->assertTrue($unit->is_active);
        $this->assertTrue($item->is_active);
    }

    public function test_catalog_factory_creates_a_valid_item_graph(): void
    {
        $item = CatalogItem::factory()->create();

        $this->assertNotNull($item->category);
        $this->assertNotNull($item->baseUnit);
        $this->assertTrue($item->is_active);
        $this->assertTrue($item->category->is_active);
        $this->assertTrue($item->baseUnit->is_active);
    }

    public function test_unit_codes_are_unique(): void
    {
        Unit::factory()->create(['code' => 'kg']);

        $this->expectException(QueryException::class);

        Unit::factory()->create(['code' => 'kg']);
    }

    public function test_category_slugs_are_unique(): void
    {
        Category::factory()->create(['slug' => 'bahan-baku']);

        $this->expectException(QueryException::class);

        Category::factory()->create(['slug' => 'bahan-baku']);
    }

    public function test_catalog_item_codes_are_unique(): void
    {
        CatalogItem::factory()->create(['code' => 'BERAS-001']);

        $this->expectException(QueryException::class);

        CatalogItem::factory()->create(['code' => 'BERAS-001']);
    }

    public function test_catalog_item_can_be_deactivated_without_being_deleted(): void
    {
        $item = CatalogItem::factory()->create();

        $item->update(['is_active' => false]);

        $this->assertFalse($item->refresh()->is_active);
        $this->assertDatabaseHas('catalog_items', ['id' => $item->id]);
        $this->assertNotNull($item->category);
        $this->assertNotNull($item->baseUnit);
    }
}
