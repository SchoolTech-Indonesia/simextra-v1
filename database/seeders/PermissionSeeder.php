<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_siswa = Role::updateOrCreate(
            [
                'name' => 'siswa'
            ], 
            ['name' =>'siswa']
        );
        $role_koordinator = Role::updateOrCreate(
            [
                'name' => 'koordinator'
            ], 
            ['name' =>'koordinator']
        );
        $role_adminsekolah= Role::updateOrCreate(
            [
                'name' => 'adminsekolah'
            ], 
            ['name' =>'adminsekolah']
        );
        $role_superadmin = Role::updateOrCreate(
            [
                'name' => 'superadmin'
            ], 
            ['name' =>'superadmin']
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

        // PERMISSION SUPERADMIN
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

        // MENAMBAHKAN PERMISSION KEDALAM ROLE SISWA
        $role_siswa->givePermissionTo($permissionAksesSekolah);
        $role_siswa->givePermissionTo($permissionAksesUser);
        $role_siswa->givePermissionTo($permissionUbahUser);
        $role_siswa->givePermissionTo($permissionAksesEkstrakurikuler);
        // MENAMBAHKAN PERMISSION KEDALAM ROLE KOORDINATOR
        $role_koordinator->givePermissionTo($permissionAksesSekolah);
        $role_koordinator->givePermissionTo($permissionAksesUser);
        $role_koordinator->givePermissionTo($permissionUbahUser);
        $role_koordinator->givePermissionTo($permissionAksesEkstrakurikuler);
        $role_koordinator->givePermissionTo($permissionUbahEkstrakurikuler);
        // MENAMBAHKAN PERMISSION KEDALAM ROLE ADMIN SEKOLAH
        $role_adminsekolah->givePermissionTo($permissionAksesSekolah);
        $role_adminsekolah->givePermissionTo($permissionUbahSekolah);
        $role_adminsekolah->givePermissionTo($permissionTambahSekolah);
        $role_adminsekolah->givePermissionTo($permissionTambahUser);
        $role_adminsekolah->givePermissionTo($permissionUbahUser);
        $role_adminsekolah->givePermissionTo($permissionAksesEkstrakurikuler);
        $role_adminsekolah->givePermissionTo($permissionUbahEkstrakurikuler);

        // MENAMBAHKAN PERMISSION KEDALAM ROLE ADMIN SEKOLAH
        $role_superadmin->givePermissionTo($permissionAkses);
        $role_superadmin->givePermissionTo($permissionTambah);
        $role_superadmin->givePermissionTo($permissionUbah);
        $role_superadmin->givePermissionTo($permissionAksesUser);
        $role_superadmin->givePermissionTo($permissionTambahUser);
        $role_superadmin->givePermissionTo($permissionUbahUser);
        $role_superadmin->givePermissionTo($permissionAksesSekolah);
        $role_superadmin->givePermissionTo($permissionUbahSekolah);
        $role_superadmin->givePermissionTo($permissionAksesEkstrakurikuler);
        $role_superadmin->givePermissionTo($permissionUbahEkstrakurikuler);
    }
}
