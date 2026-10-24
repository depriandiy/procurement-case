<?php

namespace Tests\Feature;

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
}
