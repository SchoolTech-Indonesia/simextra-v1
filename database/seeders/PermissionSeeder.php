<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
use App\Models\Role; // Import the new Role model


// Rest of the seeder code remains the same

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_Student = Role::updateOrCreate(
            [
                'name' => 'Student'
            ], 
            ['name' =>'Student']
        );
        $role_Koordinator  = Role::updateOrCreate(
            [
                'name' => 'Koordinator'
            ], 
            ['name' =>'Koordinator']
        );
        $role_Admin= Role::updateOrCreate(
            [
                'name' => 'Admin'
            ], 
            ['name' =>'Admin']
        );
        $role_SuperAdmin = Role::updateOrCreate(
            [
                'name' => 'Super Admin'
            ], 
            ['name' =>'Super Admin']
        );
        

        // PERMISSION USER
        $permissionAksesUser = Permission::updateOrCreate(
            [
                'name' => 'user.index',
            ],
            [
                'name' => 'user.index',
            ]
        );
        $permissionTambahUser = Permission::updateOrCreate(
            [
                'name' => 'user.create',
            ],
            [
                'name' => 'user.create',
            ]
        );
        $permissionUbahUser = Permission::updateOrCreate(
            [
                'name' => 'user.update',
            ],
            [
                'name' => 'user.update',
            ]
        );
        $permissionDeleteUser = Permission::updateOrCreate(
            [
                'name' => 'user.delete',
            ],
            [
                'name' => 'user.delete',
            ]
        );

        // PERMISSION SEKOLAH
        $permissionAksesSekolah = Permission::updateOrCreate(
            [
                'name' => 'sekolah.index',
            ],
            [
                'name' => 'sekolah.index',
            ]
        );
        $permissionTambahSekolah = Permission::updateOrCreate(
            [
                'name' => 'sekolah.create',
            ],
            [
                'name' => 'sekolah.create',
            ]
        );
        $permissionUbahSekolah = Permission::updateOrCreate(
            [
                'name' => 'sekolah.update',
            ],
            [
                'name' => 'sekolah.update',
            ]
        );
        $permissionDeleteSekolah = Permission::updateOrCreate(
            [
                'name' => 'sekolah.delete',
            ],
            [
                'name' => 'sekolah.delete',
            ]
        );

        // PERMISSION EXTRAKULIKULER
        $permissionAksesEkstrakurikuler = Permission::updateOrCreate(
            [
                'name' => 'ekstrakurikuler.index',
            ],
            [
                'name' => 'ekstrakurikuler.index',
            ]
        );
        $permissionTambahEkstrakurikuler = Permission::updateOrCreate(
            [
                'name' => 'ekstrakurikuler.create',
            ],
            [
                'name' => 'ekstrakurikuler.create',
            ]
        );
        $permissionUbahEkstrakurikuler = Permission::updateOrCreate(
            [
                'name' => 'ekstrakurikuler.update',
            ],
            [
                'name' => 'ekstrakurikuler.update',
            ]
        );
        $permissionDeleteEkstrakurikuler = Permission::updateOrCreate(
            [
                'name' => 'ekstrakurikuler.delete',
            ],
            [
                'name' => 'ekstrakurikuler.delete',
            ]
        );

        // PERMISSION Super Admin
        $permissionAkses = Permission::updateOrCreate(
            [
                'name' => 'permission.index',
            ],
            [
                'name' => 'permission.index',
            ]
        );
        $permissionTambah = Permission::updateOrCreate(
            [
                'name' => 'permission.create',
            ],
            [
                'name' => 'permission.create',
            ]
        );
        $permissionUbah = Permission::updateOrCreate(
            [
                'name' => 'permission.update',
            ],
            [
                'name' => 'permission.update',
            ]
        );
        $permissionDelete = Permission::updateOrCreate(
            [
                'name' => 'permission.delete',
            ],
            [
                'name' => 'permission.delete',
            ]
        );

        // MENAMBAHKAN PERMISSION KEDALAM ROLE Student
        $role_Student->givePermissionTo($permissionAksesSekolah);
        $role_Student->givePermissionTo($permissionAksesUser);
        $role_Student->givePermissionTo($permissionUbahUser);
        $role_Student->givePermissionTo($permissionAksesEkstrakurikuler);
        // MENAMBAHKAN PERMISSION KEDALAM ROLE KOORDINATOR
        $role_Koordinator ->givePermissionTo($permissionAksesSekolah);
        $role_Koordinator ->givePermissionTo($permissionAksesUser);
        $role_Koordinator ->givePermissionTo($permissionUbahUser);
        $role_Koordinator ->givePermissionTo($permissionAksesEkstrakurikuler);
        $role_Koordinator ->givePermissionTo($permissionUbahEkstrakurikuler);
        // MENAMBAHKAN PERMISSION KEDALAM ROLE ADMIN SEKOLAH
        $role_Admin->givePermissionTo($permissionAksesSekolah);
        $role_Admin->givePermissionTo($permissionUbahSekolah);
        $role_Admin->givePermissionTo($permissionTambahSekolah);
        $role_Admin->givePermissionTo($permissionTambahUser);
        $role_Admin->givePermissionTo($permissionUbahUser);
        $role_Admin->givePermissionTo($permissionAksesEkstrakurikuler);
        $role_Admin->givePermissionTo($permissionUbahEkstrakurikuler);

        // MENAMBAHKAN PERMISSION KEDALAM ROLE Super Admin
        $role_SuperAdmin->givePermissionTo($permissionAkses);
        $role_SuperAdmin->givePermissionTo($permissionTambah);
        $role_SuperAdmin->givePermissionTo($permissionUbah);
        $role_SuperAdmin->givePermissionTo($permissionAksesUser);
        $role_SuperAdmin->givePermissionTo($permissionTambahUser);
        $role_SuperAdmin->givePermissionTo($permissionUbahUser);
        $role_SuperAdmin->givePermissionTo($permissionAksesSekolah);
        $role_SuperAdmin->givePermissionTo($permissionUbahSekolah);
        $role_SuperAdmin->givePermissionTo($permissionAksesEkstrakurikuler);
        $role_SuperAdmin->givePermissionTo($permissionUbahEkstrakurikuler);
    }
}
