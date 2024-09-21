<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //CARA MAS ARKA
        $faker = Faker::create(); // Create a Faker instance

        // User::create([
        //     'name' => $faker->unique()->userName, // Generate a unique username
        //     'NISN_NIP' => '1234567890',
        //     'email' => $faker->unique()->safeEmail, // Generate a unique email
        //     'password' => Hash::make('1234567890'),  // Hash the password
        //     'role' => 'student', // Set role
        // ]);

        $Student = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '11111111',
            'email' => 'siswa@gmail.com',
            'phone_number' => '1234567890',
            'password' => Hash::make('Student'),
            'id_role' => '1'
            
        ]);

        $Koordinator = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '22222222',
            'email' => $faker->unique()->safeEmail,
            'phone_number' => '12345678',
            'password' => Hash::make('Koordinator'),
            'id_role' => '2'
        ]);

        $Admin = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '33333333',
            'email' => $faker->unique()->safeEmail,
            'phone_number' => '1234567',
            'password' => Hash::make('Admin'),
            'id_role' => '3'
        ]);


        $SuperAdmin = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '44444444',
            'email' => $faker->unique()->safeEmail,
            'phone_number' => '123456',
            'password' => Hash::make('SuperAdmin'),
            'id_role' => '4'
        ]);
        $koordinatorRole = Role::where('name', 'Koordinator')->first();

        if (!$koordinatorRole) {
            throw new \Exception('Koordinator role not found. Please run PermissionSeeder first.');
        }

        // Create a Koordinator user if not exists
        $koordinator = User::firstOrCreate(
            ['email' => 'koordinator@example.com'],
            [
                'name' => 'Koordinator User',
                'password' => Hash::make('password'), // Use a secure password in production
                'phone_number' => '123',
                'NISN_NIP' => '1234567890',
                'id_role' => 2, // Assuming school with id 1 exists
            ]
        );
        
        
        //Cara Vinsen

        // $faker = \Faker\Factory::create();

        // // Fetch roles by name
        // $studentRole = Role::where('name', 'Student')->first();
        // $koordinatorRole = Role::where('name', 'Koordinator')->first();
        // $adminRole = Role::where('name', 'Admin')->first();
        // $superAdminRole = Role::where('name', 'Super Admin')->first();

        // if (!$studentRole || !$koordinatorRole || !$adminRole || !$superAdminRole) {
        //     throw new \Exception('One or more roles not found. Please run RoleSeeder first.');
        // }

        // // Fetch or create the school with id=1
        // $school = \App\Models\School::firstOrCreate(
        //     ['id' => 1],
        //     ['name' => 'Default School'] // Add other necessary fields
        // );

        // // Create a Student user
        // User::updateOrCreate(
        //     ['email' => 'student@example.com'],
        //     [
        //         'name' => 'Student User',
        //         'phone_number' => '1234567890',
        //         'NISN_NIP' => '123456789',
        //         'password' => Hash::make('password'),
        //         'id_role' => $studentRole->id,
        //         'id_school' => $school->id,
        //     ]
        // );

        // // Create a Koordinator user
        // User::updateOrCreate(
        //     ['email' => 'koordinator@example.com'],
        //     [
        //         'name' => 'Koordinator User',
        //         'phone_number' => '0987654321',
        //         'NISN_NIP' => '987654321',
        //         'password' => Hash::make('Koordinator'),
        //         'id_role' => $koordinatorRole->id,
        //         'id_school' => $school->id,
        //     ]
        // );

        // // Create an Admin user
        // User::updateOrCreate(
        //     ['email' => 'admin@example.com'],
        //     [
        //         'name' => 'Admin User',
        //         'phone_number' => '1112223334',
        //         'NISN_NIP' => '111222333',
        //         'password' => Hash::make('Admin'),
        //         'id_role' => $adminRole->id,
        //         'id_school' => $school->id,
        //     ]
        // );

        // // Optionally, create a Super Admin user
        // User::updateOrCreate(
        //     ['email' => 'superadmin@example.com'],
        //     [
        //         'name' => 'Super Admin User',
        //         'phone_number' => '5556667778',
        //         'NISN_NIP' => '555666777',
        //         'password' => Hash::make('SuperAdmin'),
        //         'id_role' => $superAdminRole->id,
        //         'id_school' => $school->id,
        //     ]
        // );
    }
}
