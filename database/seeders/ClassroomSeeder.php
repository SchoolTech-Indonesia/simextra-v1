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
        
        // Create classrooms
        $classroom1 = Classroom::firstOrCreate([
            'name' => 'MIPA 1',

        ]);
        
        $classroom2 = Classroom::firstOrCreate([
            'name' => 'MIPA 2',

        ]);

        $classroom3 = Classroom::firstOrCreate([
            'name' => 'IPS 1',
 
        ]);
        
        $classroom4 = Classroom::firstOrCreate([
            'name' => 'Bahasa 1',
  
        ]);

        // Associate classrooms with majors (many-to-many)
        $major1->classrooms()->syncWithoutDetaching([$classroom1->id, $classroom2->id]); // Major 1 linked to MIPA 1 and MIPA 2
        $major2->classrooms()->syncWithoutDetaching($classroom3->id); // Major 2 linked to IPS 1
        $major3->classrooms()->syncWithoutDetaching($classroom4->id); // Major 3 linked to Bahasa 1
    }
}

