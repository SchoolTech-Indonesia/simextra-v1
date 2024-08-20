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

        User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin', // Set role
        ]);

        User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '113113113113',
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('0987'),
            'role' => 'teacher', // Set role
        ]);
    }
}