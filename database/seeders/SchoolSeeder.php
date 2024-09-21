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
                'name' => 'MIPA',
                // Add other necessary fields here
            ]
        );
    }
}
