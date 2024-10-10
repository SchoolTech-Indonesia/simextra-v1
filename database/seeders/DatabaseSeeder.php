<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\Major;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(ClassroomSeeder::class);
        $this->call(ExtrasSeeder::class);
        
       // DatabaseSeeder.php
// $classroom = Classroom::find(1);
// $major = Major::find(1);

// // Set the major_id directly for the classroom
// $classroom->major_id = $major->id;
// $classroom->save();

    }
}
