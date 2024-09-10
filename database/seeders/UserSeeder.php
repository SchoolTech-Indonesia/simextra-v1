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

        $siswa = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '11111111',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('siswa'),
            
        ]);

        $koordinator = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '22222222',
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('koordinator'),
        ]);

        $adminSekolah = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '33333333',
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('adminsekolah'),
        ]);


        $superAdmin = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '44444444',
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('superadmin'),
        ]);
    }
}