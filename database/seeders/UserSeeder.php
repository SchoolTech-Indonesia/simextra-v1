<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Ensure roles are seeded
        $roleStudent = Role::firstOrCreate(['name' => 'Student']);
        $roleKoordinator = Role::firstOrCreate(['name' => 'Koordinator']);
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'Super Admin']);

        // Seed users and assign roles
        $student = User::create([
            'name' => 'andy42',
            'NISN_NIP' => '11111111',
            'email' => 'siswa@gmail.com',
            'phone_number' => '1234567890',
            'password' => Hash::make('Student'),
            'profile_photo_path' => 'https://freesvg.org/img/abstract-user-flat-4.png',
        ]);
        $student->assignRole($roleStudent);

        $koordinator = User::create([
            'name' => 'koordinator42',
            'NISN_NIP' => '22222222',
            'email' => 'koordinator@gmail.com',
            'phone_number' => '12345678',
            'password' => Hash::make('Koordinator'),
            'profile_photo_path' => 'https://freesvg.org/img/abstract-user-flat-4.png',
        ]);
        $koordinator->assignRole($roleKoordinator);

        $admin = User::create([
            'name' => 'admin42',
            'NISN_NIP' => '33333333',
            'email' => 'admin@gmail.com',
            'phone_number' => '1234567',
            'password' => Hash::make('Admin'),
            'profile_photo_path' => 'https://freesvg.org/img/abstract-user-flat-4.png',
        ]);
        $admin->assignRole($roleAdmin);

        $superAdmin = User::create([
            'name' => 'superadmin42',
            'NISN_NIP' => '44444444',
            'email' => 'superadmin@gmail.com',
            'phone_number' => '123456',
            'password' => Hash::make('SuperAdmin'),
            'profile_photo_path' => 'https://freesvg.org/img/abstract-user-flat-4.png',
        ]);
        $superAdmin->assignRole($roleSuperAdmin);
    }
}