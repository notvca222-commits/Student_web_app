<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table      = 'subject';

    // กำหนด Primary Key เป็น subject_code
    protected $primaryKey = 'subject_code';

    // หาก subject_code เป็นข้อความหรือตัวเลขที่ไม่ใช่ auto-increment
    public $incrementing  = false;
    protected $keyType    = 'string';

    public $timestamps    = false;

    protected $fillable   = [
        'subject_code',
        'subject_name',
        'credit',
    ];
}
