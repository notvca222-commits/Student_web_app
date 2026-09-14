<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherLoginController extends Controller
{
    // แสดงหน้า Login
    public function showLoginForm()
    {
        return view('auth.teacher-login');
    }


    // Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');


        if (
            Auth::guard('teacher')->attempt([
                't_username' => $credentials['username'],
                'password' => $credentials['password'],
            ], $remember)
        ) {

            $request->session()->regenerate();

            $teacher = Auth::guard('teacher')->user();


            // ถ้าเป็น Admin
            if ($teacher->isAdmin()) {

                return redirect()
                    ->intended('teachers');
            }


            // อาจารย์ทั่วไป
            return redirect()
                ->route('teacher.dashboard');
        }


        return back()
            ->withInput(
                $request->only('username')
            )
            ->with(
                'error',
                'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'
            );
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()
            ->route('teacher.login')
            ->with(
                'status',
                'ออกจากระบบเรียบร้อยแล้ว'
            );
    }
}
