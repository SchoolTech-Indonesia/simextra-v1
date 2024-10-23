<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusPresensi;
use Illuminate\Support\Str;

class StatusPresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Hadir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Sakit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Izin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Alpha',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Truncate the table first to avoid duplicate entries
        StatusPresensi::query()->delete();

        // Insert the statuses
        foreach ($statuses as $status) {
            StatusPresensi::create($status);
        }
    }
}