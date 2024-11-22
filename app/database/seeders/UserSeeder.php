<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('taler113099')
        ]);

        $admin->assignRole('admin');

        $staff = User::create([
            'name' => 'staff',
            'username' => 'staff',
            'password' => Hash::make('taler113099')
        ]);

        $staff->assignRole('staff');
    }
}
