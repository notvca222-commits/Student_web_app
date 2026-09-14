<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TeacherRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Teacher Self Register
    |--------------------------------------------------------------------------
    */

    // แสดงหน้าสมัครสมาชิกอาจารย์
    public function showRegisterForm()
    {
        $faculties = Faculty::orderBy('faculty_name')->get();

        $programs = Program::orderBy('program_name')->get();

        return view(
            'auth.teacher-register',
            compact('faculties', 'programs')
        );
    }


    // บันทึกการสมัครสมาชิกอาจารย์
    public function register(Request $request)
    {
        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',

            't_faculty_id' => 'required|exists:faculty,faculty_id',

            't_program_id' => 'required|exists:program,program_id',

            't_email' => 'required|email|max:255|unique:teacher,t_email',

            't_address' => 'nullable|string|max:255',

            't_username' => 'required|string|max:255|unique:teacher,t_username',

            't_password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        // เข้ารหัส Password
        $validated['t_password'] = Hash::make(
            $validated['t_password']
        );

        // อาจารย์ที่สมัครเองเป็นอาจารย์ทั่วไป
        $validated['t_role'] = 0;

        Teacher::create($validated);

        return redirect()
            ->route('teacher.login')
            ->with(
                'success',
                'สมัครสมาชิกอาจารย์เรียบร้อยแล้ว กรุณาเข้าสู่ระบบ'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Teacher Management
    |--------------------------------------------------------------------------
    */

    // แสดงรายการอาจารย์
    public function index(Request $request)
    {
        $search = $request->input('search');

        $teachers = Teacher::with([
                'faculty',
                'program'
            ])
            ->when($search, function ($query, $search) {

                $query->where(
                    'teacher_name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    't_email',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    't_username',
                    'like',
                    "%{$search}%"
                );
            })
            ->orderBy('teacher_name')
            ->paginate(10)
            ->withQueryString();


        // จำนวนข้อมูลในระบบ
        $totalFaculties = DB::table('faculty')->count();

        $totalPrograms = DB::table('program')->count();

        $totalStudents = DB::table('student')->count();

        $totalTeachers = DB::table('teacher')->count();


        return view(
            'teachers.index',
            compact(
                'teachers',
                'search',
                'totalFaculties',
                'totalPrograms',
                'totalStudents',
                'totalTeachers'
            )
        );
    }


    // แสดงหน้าเพิ่มอาจารย์
    public function add()
    {
        $faculties = Faculty::orderBy(
            'faculty_name'
        )->get();

        $programs = Program::orderBy(
            'program_name'
        )->get();

        return view(
            'teachers.create',
            compact(
                'faculties',
                'programs'
            )
        );
    }


    // บันทึกอาจารย์จากหน้า Admin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',

            't_faculty_id' =>
                'required|exists:faculty,faculty_id',

            't_program_id' =>
                'required|exists:program,program_id',

            't_email' =>
                'required|email|max:255|unique:teacher,t_email',

            't_address' =>
                'nullable|string|max:255',

            't_username' =>
                'required|string|max:255|unique:teacher,t_username',

            't_password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],

            't_role' =>
                'required|in:0,1',
        ]);


        // เข้ารหัส Password
        $validated['t_password'] =
            Hash::make(
                $validated['t_password']
            );


        Teacher::create($validated);


        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'บันทึกข้อมูลอาจารย์เรียบร้อยแล้ว'
            );
    }


    // แสดงรายละเอียดอาจารย์
    public function show(Teacher $teacher)
    {
        $teacher->load([
            'faculty',
            'program'
        ]);

        return view(
            'teachers.show',
            compact('teacher')
        );
    }


    // แสดงหน้าแก้ไข
    public function edit($teacher_id)
    {
        $teacher =
            Teacher::findOrFail(
                $teacher_id
            );

        $faculties =
            Faculty::orderBy(
                'faculty_name'
            )->get();

        $programs =
            Program::orderBy(
                'program_name'
            )->get();


        return view(
            'teachers.edit',
            compact(
                'teacher',
                'faculties',
                'programs'
            )
        );
    }


    // อัปเดตข้อมูลอาจารย์
    public function update(
        Request $request,
        $teacher_id
    ) {
        $validated = $request->validate([
            'teacher_name' =>
                'required|string|max:255',

            't_faculty_id' =>
                'required|exists:faculty,faculty_id',

            't_program_id' =>
                'required|exists:program,program_id',

            't_email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'teacher',
                    't_email'
                )->ignore(
                    $teacher_id,
                    'teacher_id'
                ),
            ],

            't_address' =>
                'nullable|string|max:255',

            't_username' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'teacher',
                    't_username'
                )->ignore(
                    $teacher_id,
                    'teacher_id'
                ),
            ],
        ]);


        $teacher =
            Teacher::findOrFail(
                $teacher_id
            );


        $teacher->update(
            $validated
        );


        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'แก้ไขข้อมูลอาจารย์เรียบร้อยแล้ว'
            );
    }


    // ลบอาจารย์
    public function destroy($teacher_id)
    {
        $teacher =
            Teacher::findOrFail(
                $teacher_id
            );

        $teacher->delete();


        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'ลบข้อมูลอาจารย์เรียบร้อยแล้ว'
            );
    }
}
