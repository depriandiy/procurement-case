<?php

namespace Tests\Feature;

use App\Models\CatalogItem;
use App\Models\Category;
use App\Models\Unit;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_can_run_repeatedly_without_duplicating_the_demo_user(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $user = User::query()->where('email', 'test@example.com')->sole();

        $this->assertSame(1, User::query()->where('email', 'test@example.com')->count());
        $this->assertSame('Test User', $user->name);
        $this->assertTrue(Hash::check(env('DEMO_USER_PASSWORD', 'password'), $user->password));
    }

    public function test_database_seeder_provides_an_idempotent_procurement_catalog(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(6, Unit::query()->count());
        $this->assertSame(4, Category::query()->count());
        $this->assertSame(8, CatalogItem::query()->count());
        $this->assertDatabaseHas('catalog_items', [
            'code' => 'ATK-KRT-A4-80',
            'name' => 'Kertas HVS A4 80 gsm',
        ]);
        $this->assertDatabaseHas('catalog_items', [
            'code' => 'IT-LAPTOP-14',
            'name' => 'Laptop Bisnis 14 inci',
        ]);
    }
}
