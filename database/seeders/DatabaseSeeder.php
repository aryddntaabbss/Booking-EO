<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin EO',
            'email' => 'admin@booking-eo.test',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Client Demo',
            'email' => 'client@booking-eo.test',
            'role' => 'client',
        ]);
    }
}
