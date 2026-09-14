<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\Program;

class BasicDataSeeder extends Seeder
{
    public function run()
    {
        // สร้างคณะ
        $faculties = [
            ['faculty_id' => 'F01', 'faculty_name' => 'วิทยาศาสตร์และเทคโนโลยี'],
            ['faculty_id' => 'F02', 'faculty_name' => 'ครุศาสตร์'],
            ['faculty_id' => 'F03', 'faculty_name' => 'มนุษยศาสตร์และสังคมศาสตร์'],
            ['faculty_id' => 'F04', 'faculty_name' => 'วิทยาการจัดการ'],
        ];

        foreach ($faculties as $f) {
            Faculty::updateOrCreate(['faculty_id' => $f['faculty_id']], $f);
        }

        // สร้างสาขา (ไม่ได้ระบุความสัมพันธ์ในตาราง program หรือเปล่า? ขอดู structure อีกที)
        // Wait, does Program have faculty_id ? The migration output didn't show it?
        // Let me check migration files first.
    }
}

