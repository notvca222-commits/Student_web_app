<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed Faculty
        $faculties = [
            ['faculty_id' => 'F01', 'faculty_name' => 'วิทยาศาสตร์และเทคโนโลยี'],
            ['faculty_id' => 'F02', 'faculty_name' => 'ครุศาสตร์'],
        ];
        foreach ($faculties as $f) {
            \App\Models\Faculty::updateOrCreate(['faculty_id' => $f['faculty_id']], $f);
        }

        // Seed Program
        $programs = [
            ['program_id' => 'P01', 'program_name' => 'วิทยาการคอมพิวเตอร์', 'faculty_id' => 'F01'],
            ['program_id' => 'P02', 'program_name' => 'เทคโนโลยีสารสนเทศ', 'faculty_id' => 'F01'],
            ['program_id' => 'P03', 'program_name' => 'คณิตศาสตร์', 'faculty_id' => 'F02'],
        ];
        foreach ($programs as $p) {
            \App\Models\Program::updateOrCreate(['program_id' => $p['program_id']], $p);
        }
    }
}
