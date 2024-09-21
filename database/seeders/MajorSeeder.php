<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Models\User;
use App\Models\Classroom;
use Spatie\Permission\Models\Role;

class MajorSeeder extends Seeder
{
    public function run()
    {
        // Fetch the Koordinator role
        $koordinatorRole = Role::where('name', 'Koordinator')->first();

        if (!$koordinatorRole) {
            throw new \Exception('Koordinator role not found. Please run RoleSeeder first.');
        }

        // Fetch users with the Koordinator role by id_role
        $koordinators = User::where('id_role', $koordinatorRole->id)->get();

        if ($koordinators->isEmpty()) {
            throw new \Exception('No users found with the "Koordinator" role.');
        }

        // Generate the major code based on the current count of majors
        $count = Major::count();
        $generatedCode = 'JRS' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        // Create the major
        $major = Major::create([
            'code' => $generatedCode,
            'name' => 'Matematika dan IPA',
            'koordinator_id' => $koordinators->first()->id,
            // Remove 'classroom_id' if it's not needed in majors table
        ]);

        // // Create classrooms linked to the major
        // Classroom::create([
        //     'name' => 'Bahasa',
        //     // 'code' => 'CLS001',
        //     'major_id' => $major->id,
        //     // Add other necessary fields
        // ]);

        // Optionally, create more classrooms for the major
        Classroom::create([
            'name' => 'IPS',
            'code' => 'CLS002',
            'major_id' => $major->id,
            // Add other necessary fields
        ]);
    }
}
