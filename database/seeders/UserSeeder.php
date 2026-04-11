<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2 admins
User::factory(2)->create(['role' => 'admin']);

// 5 recruteurs
User::factory(5)->create(['role' => 'recruteur']);

// 10 candidats
User::factory(10)->create(['role' => 'candidat']);
    }
}
