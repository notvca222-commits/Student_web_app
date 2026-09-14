<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'student_id' => 'required|string',
            'password'   => 'required|string',
        ]);

        if (Auth::guard('student')->attempt(
            ['student_id' => $credentials['student_id'], 'password' => $credentials['password']],
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();
            return redirect()->intended(route('student.dashboard'));
        }

        return back()
            ->withErrors(['student_id' => 'รหัสนักศึกษาหรือรหัสผ่านไม่ถูกต้อง'])
            ->onlyInput('student_id');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return redirect()->route('student.login');
        return redirect()->route('home');
    }
}
