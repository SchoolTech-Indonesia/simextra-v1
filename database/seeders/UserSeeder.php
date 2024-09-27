<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    private $defaultPhotoUrl = 'https://freesvg.org/img/abstract-user-flat-4.png';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Create a Faker instance

        $student = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '11111111',
            'email' => 'siswa@gmail.com',
            'phone_number' => '1234567890',
            'password' => Hash::make('Student'),
            'id_role' => '1',
            'profile_photo_path' => $this->defaultPhotoUrl 
        ]);

        $koordinator = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '22222222',
            'email' => $faker->unique()->safeEmail,
            'phone_number' => '12345678',
            'password' => Hash::make('Koordinator'),
            'id_role' => '2',
            'profile_photo_path' => $this->defaultPhotoUrl
        ]);

        $admin = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '33333333',
            'email' => $faker->unique()->safeEmail,
            'phone_number' => '1234567',
            'password' => Hash::make('Admin'),
            'id_role' => '3',
            'profile_photo_path' => $this->defaultPhotoUrl 
        ]);

        $superAdmin = User::create([
            'name' => $faker->unique()->userName,
            'NISN_NIP' => '44444444',
            'email' => $faker->unique()->safeEmail,
            'phone_number' => '123456',
            'password' => Hash::make('SuperAdmin'),
            'id_role' => '4',
            'profile_photo_path' => $this->defaultPhotoUrl
        ]);

    }
}
