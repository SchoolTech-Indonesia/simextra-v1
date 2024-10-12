<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Models\Classroom;

class MajorSeeder extends Seeder
{
    public function run()
    {
        // Create majors with manually assigned IDs
        $matematikaDanIPA = Major::create([
            'id' => 1,
            'name' => 'Matematika dan IPA',
        ]);

        Major::create([
            'id' => 2,
            'name' => 'IPS',
        ]);
        
    }
}
