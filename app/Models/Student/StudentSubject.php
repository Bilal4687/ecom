<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    use HasFactory;

    protected $table = 'student_subjects';

    protected $primaryKey = 'subject_id';

    protected $fillable = ['subject_name','obtain_marks'];
}
