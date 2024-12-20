<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Shelter;

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

        $shelter = Shelter::find(1);

        $staff = User::create([
            'name' => 'staff',
            'username' => 'staff',
            'password' => Hash::make('taler113099'),
            'shelter_id' => $shelter->id
        ]);

        $staff->assignRole('staff');
    }
}
