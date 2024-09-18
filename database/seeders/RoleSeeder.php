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
                'name' => 'Student'
            ], 
            ['name' =>'Student']
        );
        Role::updateOrCreate(
            [
                'name' => 'Koordinator'
            ], 
            ['name' =>'Koordinator']
        );
        Role::updateOrCreate(
            [
                'name' => 'Admin'
            ], 
            ['name' =>'Admin']
        );
        Role::updateOrCreate(
            [
                'name' => 'Super Admin'
            ], 
            ['name' =>'Super Admin']
        );
    }
}
