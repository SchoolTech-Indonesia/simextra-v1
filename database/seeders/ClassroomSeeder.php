<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\Major;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a few majors first
        $major1 = Major::firstOrCreate(['name' => 'Matematika dan IPA']);
        $major2 = Major::firstOrCreate(['name' => 'IPS']);
        $major3 = Major::firstOrCreate(['name' => 'Bahasa']);
        
        // Create classrooms and associate them with a major (one-to-many)
        $classroom1 = Classroom::firstOrCreate([
            'name' => 'MIPA 1',
            'code' => 'ClSRM001',
            'major_id' => $major1->id,  // Associate with major1
        ]);
        
        $classroom2 = Classroom::firstOrCreate([
            'name' => 'MIPA 2',
            'code' => 'ClSRM002',
            'major_id' => $major1->id,  // Associate with major1
        ]);

        $classroom3 = Classroom::firstOrCreate([
            'name' => 'IPS 1',
            'code' => 'CLSRM003',
            'major_id' => $major2->id,  // Associate with major2
        ]);
        
        $classroom4 = Classroom::firstOrCreate([
            'name' => 'Bahasa 1',
            'code' => 'CLSRM004',
            'major_id' => $major3->id,  // Associate with major3
        ]);
    }
}
