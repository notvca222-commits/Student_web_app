<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Student extends Authenticatable
{
    protected $table      = 'student';
    protected $primaryKey = 'student_id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'student_name',
        'faculty_id',
        'program_id',
        'birth_date',
        'email',
        'address',
        'username',
        'password',
        'created_at',
        'updated_at'

    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Student อยู่ใน Faculty
    public function faculty()
    {
        return $this->belongsTo(
            Faculty::class,
            'faculty_id',
            'faculty_id'
        );
    }

    // Student อยู่ใน Program
    public function program()
    {
        return $this->belongsTo(
            Program::class,
            'program_id',
            'program_id'
        );
    }

    // Student มีหลาย Registration
    // public function registrations()
    // {
    //     return $this->hasMany(
    //         Registration::class,
    //         'student_id',
    //         'id'
    //     );
    // }
}
