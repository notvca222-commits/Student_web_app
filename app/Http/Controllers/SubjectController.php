<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * แสดงรายการรายวิชาทั้งหมด พร้อมค้นหาและแบ่งหน้า
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $subjects = Subject::when($search, function ($query, $search) {
            $query->where('subject_name', 'like', "%{$search}%")
                ->orWhere('subject_code', 'like', "%{$search}%");
        })
            ->orderBy('subject_code')
            ->paginate(10)
            ->withQueryString();

        $totalSubjects = Subject::count();
        $totalCredits  = Subject::sum('credit');

        return view('subjects.index', compact(
            'subjects',
            'search',
            'totalSubjects',
            'totalCredits'
        ));
    }

    /**
     * แสดงฟอร์มเพิ่มรายวิชาใหม่
     */
    public function add()
    {
        return view('subjects.add');
    }

    /**
     * บันทึกรายวิชาใหม่ลงฐานข้อมูล
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:7|unique:subject,subject_code',
            'subject_name' => 'required|string|max:255',
            'credit'       => 'required|integer|min:1|max:9',
        ]);

        Subject::create($validated);

        return redirect('subjects')
            ->with('success', 'เพิ่มรายวิชาเรียบร้อยแล้ว');
    }

    /**
     * แสดงฟอร์มแก้ไขรายวิชา
     */
    public function edit($id)
    {
        // ค้นหาจาก subject_code โดยตรง เพื่อป้องกัน SQL Error: Unknown column 'subject.id'
        $subject = Subject::where('subject_code', $id)->firstOrFail();

        return view('subjects.updateForm', compact('subject'));
    }

    /**
     * อัปเดตข้อมูลรายวิชา
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::where('subject_code', $id)->firstOrFail();

        $validated = $request->validate([
            'subject_code' => 'required|string|max:7|unique:subject,subject_code,' . $subject->subject_code . ',subject_code',
            'subject_name' => 'required|string|max:255',
            'credit'       => 'required|integer|min:1|max:9',
        ]);

        $subject->update($validated);

        return redirect('subjects')
            ->with('success', 'แก้ไขข้อมูลรายวิชาเรียบร้อยแล้ว');
    }

    /**
     * ลบรายวิชา (เช็คก่อนว่ามีการลงทะเบียนเรียนวิชานี้อยู่หรือไม่)
     */
    public function destroy($id)
    {
        // ค้นหาจาก subject_code แทน $id
        $subject = Subject::where('subject_code', $id)->firstOrFail();

        // เช็คว่าตาราง register_detail มีหรือไม่
        $hasRegistrations = false;
        if (Schema::hasTable('register_detail')) {
            $hasRegistrations = DB::table('register_detail')
                ->where('subject_code', $subject->subject_code)
                ->exists();
        }

        if ($hasRegistrations) {
            return redirect('subjects')
                ->with('error', 'ไม่สามารถลบได้ เนื่องจากรายวิชานี้มีการลงทะเบียนเรียนอยู่แล้ว');
        }

        $subject->delete();

        return redirect('subjects')
            ->with('success', 'ลบรายวิชาเรียบร้อยแล้ว');
    }
}
