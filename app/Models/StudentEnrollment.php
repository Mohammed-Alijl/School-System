<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnrollment extends Model
{
    use HasFactory;

    public const STATUS_PROMOTED = 'promoted';
    public const STATUS_REPEATING = 'repeating';
    public const STATUS_GRADUATED = 'graduated';

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'grade_id',
        'classroom_id',
        'section_id',
        'enrollment_status',
        'admin_id',
    ];

    //======================== RELATIONSHIPS ========================
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class, 'classroom_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
