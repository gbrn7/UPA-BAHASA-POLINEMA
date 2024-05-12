<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseEventScheduleModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'r_course_event_schedule';
    protected $primaryKey = 'course_event_schedule_id';

    protected $fillable = ([
        'course_event_type_course_id',
        'quota',
        'remaining_quota',
        'day_name',
        'time_start',
        'time_end',
        'created_by',
        'updated_by',
        'deleted_by',
    ]);
}
