<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'MainUser',
            'email' => 'main@example.com',
        ]);

        User::factory()->create([
            'username' => 'TestUser',
            'email' => 'test@example.com',
        ]);
    }
}
