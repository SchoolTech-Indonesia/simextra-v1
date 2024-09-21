<?php

namespace App\Imports;

use App\Models\User;
use Spatie\Permission\Models\Role; // Gunakan model Role dari Spatie
use App\Models\School;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $role = Role::find($row[5]); 
            $school = School::find($row[6]);

            if ($role && $school) {
                try {
                    User::create([
                        'name' => $row[0],
                        'email' => $row[1],
                        'phone_number' => $row[2],
                        'NISN_NIP' => (int) $row[3],
                        'password' => Hash::make($row[4]),
                        'id_role' => $row[5],
                        'id_school' => $row[6],
                        
                    ]);
                } catch (\Exception $e) {
                    Log::error("Error inserting user: " . $e->getMessage() . " with data: " . json_encode($row));
                }
            } else {
                Log::error("Invalid role or school ID for row: " . json_encode($row));
            }
        }
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|numeric|unique:users,phone_number',
            'NISN_NIP' => 'required|string|unique:users,NISN_NIP',
        ];
    }
}
