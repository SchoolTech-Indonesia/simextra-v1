<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(
            [
                'name' => 'siswa'
            ], 
            ['name' =>'siswa']
        );
        Role::updateOrCreate(
            [
                'name' => 'koordinator'
            ], 
            ['name' =>'koordinator']
        );
        Role::updateOrCreate(
            [
                'name' => 'adminsekolah'
            ], 
            ['name' =>'adminsekolah']
        );
        Role::updateOrCreate(
            [
                'name' => 'superadmin'
            ], 
            ['name' =>'superadmin']
        );
    }
}
