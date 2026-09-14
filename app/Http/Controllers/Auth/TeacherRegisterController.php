<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Teacher;
use App\Models\Faculty;
use App\Models\Program;

class TeacherRegisterController extends Controller
{
    public function showRegisterForm()
    {
         $faculties = Faculty::orderBy('faculty_name')->get();
         return view('auth.teacher-register', compact('faculties'));
       
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'teacher_name'  => 'required|string|max:100',
            't_faculty_id'  => 'required|exists:faculty,faculty_id',
            't_program_id'  => 'required|exists:program,program_id',
            't_email'       => 'required|email|max:100|unique:teacher,t_email',
            't_address'     => 'required|string|max:100',
            't_username'    => 'required|string|max:50|unique:teacher,t_username',
            't_password'    => ['required', 'confirmed', Password::min(8)
                ->mixedCase()->numbers()->symbols()],
        ], [
            't_email.unique'    => 'อีเมลนี้ถูกใช้สมัครแล้ว',
            't_username.unique' => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',
        ]);

        $teacher = Teacher::create([
            'teacher_name' => $validated['teacher_name'],
            't_faculty_id' => $validated['t_faculty_id'],
            't_program_id' => $validated['t_program_id'],
            't_email'      => $validated['t_email'],
            't_address'    => $validated['t_address'],
            't_username'   => $validated['t_username'],
            't_password'   => Hash::make($validated['t_password']),
            't_role'       => 1, // อาจารย์ทั่วไป — ห้ามให้สมัครแล้วได้ role admin เอง
        ]);

        Auth::guard('teacher')->login($teacher);

        return redirect()->route('teacher.dashboard')
            ->with('success', 'สมัครสมาชิกสำเร็จ ยินดีต้อนรับเข้าสู่ระบบ');
    }
}

