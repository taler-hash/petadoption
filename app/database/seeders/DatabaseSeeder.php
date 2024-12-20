<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ShelterSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $shelters = new ShelterSeeder();
        $roles = new RoleSeeder();
        $users = new UserSeeder();

        $shelters->run();
        $roles->run();
        $users->run();
    }
}
