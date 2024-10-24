<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicantSeeder extends Seeder
{
    public function run()
    {
        DB::table('applicants')->insert([
            [
                'user_id' => 1,  // Replace with the actual user ID
                'id_extrakurikuler' => Str::uuid(),
                'id_status_applicant' => 3,  // Assuming 3 is the ID for "Proses Verifikasi"
                'name' => 'John Doe',
                'applicant_code' => 'APPL' . uniqid(),
                'classroom_id' => null,  // No classroom assigned yet
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,  // Replace with the actual user ID
                'id_extrakurikuler' => Str::uuid(),
                'id_status_applicant' => 1,  // Assuming 1 is the ID for "Diterima"
                'name' => 'Jane Smith',
                'applicant_code' => 'APPL' . uniqid(),
                'classroom_id' => 1,  // Replace with actual classroom ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,  // Replace with the actual user ID
                'id_extrakurikuler' => Str::uuid(),
                'id_status_applicant' => 2,  // Assuming 2 is the ID for "Ditolak"
                'name' => 'Robert Brown',
                'applicant_code' => 'APPL' . uniqid(),
                'classroom_id' => 2,  // Replace with actual classroom ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
