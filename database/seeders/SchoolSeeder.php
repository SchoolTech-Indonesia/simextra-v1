<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        School::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'SMA 1 Malang',
                'address' => 'Malang',
                'logo_img' => '' // Add the default logo path
                // Add other necessary fields here
            ]
        );
    }
}