<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            'password' => Hash::make('Student'),
            'id_role' => '1'
            
        ]);

        $Koordinator = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '22222222',
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('Koordinator'),
            'id_role' => '2'
        ]);

        $Admin = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '33333333',
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('Admin'),
            'id_role' => '3'
        ]);


        $SuperAdmin = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '44444444',
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('SuperAdmin'),
            'id_role' => '4'
        ]);
    }
}