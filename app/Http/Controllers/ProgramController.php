<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Faculty;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {

        $query = Program::with(['faculty', 'students'])
            ->orderBy('program_id', 'asc');

        if ($request->search) {
            $query->where('program_name', 'like', "%{$request->search}%")
                ->orWhere('program_id', 'like', "%{$request->search}%")
                ->orWhereHas('faculty', function ($q) use ($request) {
                    $q->where('faculty_name', 'like', "%{$request->search}%");
                });
        }

        $programs = $query->paginate(10)->withQueryString();

        $totalPrograms  = DB::table('program')->count();
        $totalStudents  = DB::table('student')->count();
        $totalfaculties = Faculty::count();

        return view('programs.index', compact(
            'programs',
            'totalPrograms',
            'totalStudents',
            'totalfaculties'
        ));
    }

    public function add()
    {
        // ดึงข้อมูลคณะทั้งหมดจากตาราง faculty
        $faculties = Faculty::all();
        return view('programs.add', compact('faculties'));
    }
    public function createProgram(Request $request)
    {

        $request->validate([
            'program_id'   => 'required|max:10|unique:program,program_id',
            'program_name' => 'required|max:100',
            'faculty_id'   => 'required|exists:faculty,faculty_id',
        ], [
            'program_id.required'   => 'กรุณากรอกรหัสสาขาวิชา',
            'program_id.unique'     => 'รหัสสาขาวิชานี้มีอยู่แล้ว',
            'program_name.required' => 'กรุณากรอกชื่อสาขาวิชา',
            'faculty_id.required'   => 'กรุณาเลือกคณะ',
            'faculty_id.exists'     => 'ไม่พบคณะที่เลือกในระบบ',
        ]);

        Program::create([
            'program_id'   => $request->program_id,
            'program_name' => $request->program_name,
            'faculty_id'   => $request->faculty_id,
        ]);

        return redirect('programs')
            ->with('success', "เพิ่มสาขาวิชา '{$request->program_name}' เรียบร้อยแล้ว");
    }

    public function deleteProgram($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect('programs')->with('success', 'Program deleted successfully!');
    }

    public function editProgram($id)
    {
        $program   = Program::findOrFail($id);
        $faculties = Faculty::all();
        return view('programs.updateForm', compact('program', 'faculties'));
    }

    public function updateProgram(Request $request, $id)
    {
        $request->validate([
            'program_name' => 'required|max:100',
            'faculty_id'   => 'required|exists:faculty,faculty_id',
        ], [
            'program_name.required' => 'กรุณากรอกชื่อสาขาวิชา',
            'faculty_id.required'   => 'กรุณาเลือกคณะ',
        ]);

        Program::findOrFail($id)->update([
            'program_name' => $request->program_name,
            'faculty_id'   => $request->faculty_id,
        ]);



        return redirect('programs')->with('success', 'Program updated successfully!');
    }

    public function getByFaculty($faculty_id)
{
    $programs = Program::where('faculty_id', $faculty_id)
        ->orderBy('program_name', 'asc')
        ->get(['program_id', 'program_name']);

    return response()->json($programs);
}
}
