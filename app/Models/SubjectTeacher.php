<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjectTeacher extends Model
{
    use HasFactory;

    protected $table = 'subject_teacher';
    public $timestamps = false; // Add this just in case, typical for join tables

    protected $fillable = [
        'subject_code',
        'teacher_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_code', 'subject_code');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }
}

