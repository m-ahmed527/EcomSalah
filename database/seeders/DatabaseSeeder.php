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
        // User::factory(10)->create();

        User::updateOrCreate(['email' => 'admin@example.com'], [
            'first_name' => 'Admin',
            'last_name' => 'Ahmed',
            // 'email' => 'admin@example.com',
            'phone' => '+923242534131',
            'role' => User::ADMIN,
            'status' => User::ACTIVE,
            'password' => 'password',
        ]);
        $this->call([
            SettingSeeder::class,

        ]);
    }
}
