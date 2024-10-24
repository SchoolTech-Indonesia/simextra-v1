<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Extra;

class ExtrasSeeder extends Seeder
{
    public function run()
    {
        $extras = [
            [
                'name' => 'Futsal',
                'logo' => 'extras/futsal.png',
            ],
            [
                'name' => 'Basket',
                'logo' => 'extras/basket.png',
            ],
            [
                'name' => 'Pramuka',
                'logo' => 'extras/pramuka.png',
            ],
            [
                'name' => 'Paduan Suara',
                'logo' => 'extras/paduan_suara.png',
            ],
            [
                'name' => 'Robotik',
                'logo' => 'extras/robotik.png',
            ],
        ];

        foreach ($extras as $extra) {
            Extra::create($extra);
        }
    }
}