<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    public function run()
    {
        // Generate major code
        $count = Major::count();
        $generatedCode = 'MJR' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        // Create the major
        Major::create([
            'code' => $generatedCode,
            'name' => 'Matematika dan IPA',
        ]);
    }
}
