<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use App\Models\Major;
    use App\Models\User;
    use App\Models\Classroom;
    use Spatie\Permission\Models\Role;

    class MajorSeeder extends Seeder
    {
        public function run()
        {

            // Generate the major code based on the current count of majors
            $count = Major::count();
            $generatedCode = 'JRS' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

            {
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Matematika dan IPA',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'IPS',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Bahasa',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Ekonomi',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Elektro',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Geografi',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Komputer',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Akuntansi',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Mesin',
                ]);
            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Multimedia',
                ]);
                            
                $major = Major::create([
                    'code' => $generatedCode,
                    'name' => 'Tata Boga',
                ]);
            }
            // // Create classrooms linked to the major
            // Classroom::create([
            //     'name' => 'Bahasa',
            //     // 'code' => 'CLS001',
            //     'major_id' => $major->id,
            //     // Add other necessary fields
            // ]);

            // Optionally, create more classrooms for the major
            Classroom::create([
                'name' => 'MIPA',
                'code' => 'CLS001',
                'major_id' => $major->id,
                // Add other necessary fields
            ]);
        }
    }
