<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Seeder;

class IdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $getUsers = fn () => User::inRandomOrder()->limit(5)->get();

        $users = $getUsers();
        if ($users->isEmpty()) {
            $this->call(UserSeeder::class);
            $users = $getUsers();
        }

        foreach ($users as $user) {
            Idea::factory()->count(10)
                ->create([
                    'user_id' => $user->id,
                ]);
        }
    }
}
