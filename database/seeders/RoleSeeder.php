<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(['name' => 'Student']);
        Role::updateOrCreate(['name' => 'Koordinator']);
        Role::updateOrCreate(['name' => 'Admin']);
        Role::updateOrCreate(['name' => 'Super Admin']);
    }
}
