<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CompetenceSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([UserSeeder::class, CompetenceSeeder::class]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',

        ]);
        User::factory()->create([
            'name'     => 'Admin Test',
            'email'    => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);
    }
}
