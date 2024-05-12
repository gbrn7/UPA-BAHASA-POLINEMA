<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseEventTypeCourseModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'r_course_event_type_course';
    protected $primaryKey = 'course_event_type_course_id';

    protected $fillable = ([
        'course_type_id',
        'created_by',
        'updated_by',
        'deleted_by',    
    ]);
}
