<?php

namespace Database\Seeders;

use App\Models\CatalogItem;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class DomainCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['code' => 'PCS', 'name' => 'Piece', 'symbol' => 'pcs', 'dimension' => 'count'],
            ['code' => 'BOX', 'name' => 'Box', 'symbol' => 'box', 'dimension' => 'package'],
            ['code' => 'RIM', 'name' => 'Rim', 'symbol' => 'rim', 'dimension' => 'package'],
            ['code' => 'PACK', 'name' => 'Pack', 'symbol' => 'pack', 'dimension' => 'package'],
            ['code' => 'UNIT', 'name' => 'Unit', 'symbol' => 'unit', 'dimension' => 'count'],
            ['code' => 'METER', 'name' => 'Meter', 'symbol' => 'm', 'dimension' => 'length'],
        ];

        foreach ($units as $unit) {
            Unit::query()->updateOrCreate(
                ['code' => $unit['code']],
                [...$unit, 'is_active' => true],
            );
        }

        $categories = [
            ['slug' => 'alat-tulis-kantor', 'name' => 'Alat Tulis Kantor'],
            ['slug' => 'teknologi-informasi', 'name' => 'Teknologi Informasi'],
            ['slug' => 'kelistrikan', 'name' => 'Kelistrikan'],
            ['slug' => 'fasilitas-kantor', 'name' => 'Fasilitas Kantor'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [...$category, 'is_active' => true],
            );
        }

        $unitIds = Unit::query()->pluck('id', 'code');
        $categoryIds = Category::query()->pluck('id', 'slug');
        $items = [
            ['code' => 'ATK-KRT-A4-80', 'name' => 'Kertas HVS A4 80 gsm', 'category' => 'alat-tulis-kantor', 'unit' => 'RIM'],
            ['code' => 'ATK-PENA-BIRU', 'name' => 'Pulpen Tinta Biru', 'category' => 'alat-tulis-kantor', 'unit' => 'PCS'],
            ['code' => 'ATK-MAP-A4', 'name' => 'Map Dokumen A4', 'category' => 'alat-tulis-kantor', 'unit' => 'PCS'],
            ['code' => 'IT-LAPTOP-14', 'name' => 'Laptop Bisnis 14 inci', 'category' => 'teknologi-informasi', 'unit' => 'UNIT'],
            ['code' => 'IT-MOUSE-WL', 'name' => 'Mouse Nirkabel', 'category' => 'teknologi-informasi', 'unit' => 'UNIT'],
            ['code' => 'EL-KABEL-NYM', 'name' => 'Kabel NYM 3 x 2,5 mm', 'category' => 'kelistrikan', 'unit' => 'METER'],
            ['code' => 'EL-LAMPU-LED', 'name' => 'Lampu LED 12 Watt', 'category' => 'kelistrikan', 'unit' => 'PCS'],
            ['code' => 'FAS-TISU-BOX', 'name' => 'Tisu Wajah', 'category' => 'fasilitas-kantor', 'unit' => 'BOX'],
        ];

        foreach ($items as $item) {
            CatalogItem::query()->updateOrCreate(
                ['code' => $item['code']],
                [
                    'name' => $item['name'],
                    'description' => null,
                    'category_id' => $categoryIds[$item['category']],
                    'base_unit_id' => $unitIds[$item['unit']],
                    'is_active' => true,
                ],
            );
        }
    }
}
