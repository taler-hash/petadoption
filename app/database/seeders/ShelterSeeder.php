<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shelter;

class ShelterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shelter::create([
            'name' => 'Casuntingan welfare',
            'location' => 'M. L. Quezon Ave, Mandaue City, 6014 Cebu '
        ]);

        Shelter::create([
            'name' => 'Centro welfare',
            'location' => 'Centro Mandaue, Mandaue City, Cebu'
        ]);
    }
}
