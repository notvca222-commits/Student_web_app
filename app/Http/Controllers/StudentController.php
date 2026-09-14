<?php

namespace App\Http\Controllers;


use App\Models\Faculty;
//use App\Models\Student;
use App\Models\Program;
use App\Models\Student;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Logic to retrieve and display a list of students
        //return ('Hello from index controller ');
        // $students = Student::all(); // Fetch all students from the database
        $query = Student::with(['faculty', 'program'])
            ->orderBy('student_id', 'asc');

            // ฟังก์ชันในการค้นหาสามารถค้นหาด้วยชื่อ ไอดี สาขา คณะ
        if ($request->search) {
            $query->where('student_id', 'like', "%{$request->search}%")
                ->orWhere('student_name', 'like', "%{$request->search}%")
                // ->orWhere('program_id', 'like', "%{$request->search}%")
                ->orWhereHas('faculty', function ($q) use ($request) {
                    $q->where('faculty_name', 'like', "%{$request->search}%");
                })
                // จะค้นหาจากสาขาก็ต้องหาจาก table program เพราะใน tablestudentไม่มีขื่อสาขา ไม่ได้เชื่อมกัน
                ->orWhereHas('program', function ($q) use ($request) {
                    $q->where('program_name', 'like', "%{$request->search}%");
                });
        }

        // ให้แสดงแค่สิบแถวก่อน ถ้าเกินก็ไปอีกหน้า
        $students     = $query->paginate(10)->withQueryString();
        $totalFaculties = Faculty::count();
        $totalPrograms = Program::count();
        $totalStudents = Student::count();

        $totalFaculties = DB::table('faculty')->count();
        $totalPrograms = DB::table('program')->count();
        $totalStudents = DB::table('student')->count();
        // รีเทินไปที่ student index ที่อยู่ใน view
        return view('students.index', compact(
            'students',
            'totalPrograms',
            'totalStudents'
        ));
    }

    public function add()
    {
        // ดึงข้อมูลคณะทั้งหมดจากตาราง faculty
        $faculties = Faculty::all();
        return view('students.add', compact('faculties'));
    }

    public function  createStudent(Request $request)
    {
        $validated = $request->validate([
            'student_id'   => 'required|string|max:10|unique:student,student_id',
            'student_name' => 'required|string|max:100',
            'faculty_id'   => 'required|exists:faculty,faculty_id',
            'program_id'   => 'required|exists:program,program_id',
            'email'        => 'required|email|max:100|unique:student,email',
            'address'      => 'required|string|max:100',
            'username'     => 'required|string|max:50|unique:student,username',
            'password'     => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Student::create($validated);

        return redirect('students')->with('success', 'บันทึกข้อมูลนักศึกษาเรียบร้อยแล้ว');
    }

    //edit student
    public function edit($student_id)
    {
        if (Auth::guard('student')->check() && Auth::guard('student')->user()->student_id != $student_id) {
            return redirect('students')->with('error', 'คุณไม่มีสิทธิ์แก้ไขข้อมูลของนักศึกษาคนอื่น');
        }

        $student   = Student::findOrFail($student_id);
        $faculties = Faculty::orderBy('faculty_name')->get();

        return view('students.updateForm', compact('student', 'faculties'));
    }

    // Update student
    public function update(Request $request, $student_id)
    {
        if (Auth::guard('student')->check() && Auth::guard('student')->user()->student_id != $student_id) {
            return redirect('students')->with('error', 'คุณไม่มีสิทธิ์แก้ไขข้อมูลของนักศึกษาคนอื่น');
        }

        $student = Student::findOrFail($student_id);

        $validated = $request->validate([
            'student_name' => 'required|string|max:100',
            'faculty_id'   => 'required|exists:faculty,faculty_id',
            'program_id'   => 'required|exists:program,program_id',
            'email'        => 'required|email|max:100|unique:student,email,' . $student->student_id . ',student_id',
            'address'      => 'required|string|max:100',
            'username'     => 'required|string|max:50|unique:student,username,' . $student->student_id . ',student_id',
            // ไม่มี password ในนี้ ดังนั้น $student->password จะไม่ถูกแตะต้อง
        ]);

        $student->update($validated);

        return redirect('students')->with('success', 'บันทึกการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }

    //delete student
    public function deletestudent($student_id)
    {
        if (Auth::guard('student')->check() && Auth::guard('student')->user()->student_id != $student_id) {
            return redirect('students')->with('error', 'คุณไม่มีสิทธิ์ลบข้อมูลของนักศึกษาคนอื่น');
        }

        $student = Student::findOrFail($student_id);

        $student->delete();

        return redirect('students')->with('success', 'ลบข้อมูลนักศึกษาเรียบร้อยแล้ว');
    }
}
