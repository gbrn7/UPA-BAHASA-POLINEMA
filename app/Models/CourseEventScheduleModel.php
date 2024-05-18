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
        'course_events_id',
        'course_type_id',
        'quota',
        'remaining_quota',
        'day_name',
        'time_start',
        'time_end',
        'status',
        'information',
        'created_by',
        'updated_by',
        'deleted_by',
    ]);

    public function courseEvent()
    {
        return $this->belongsTo(CourseEventModel::class, 'course_events_id', 'course_events_id');
    }

    public function courseEventsRegisters()
    {
        return $this->hasMany(CourseEventRegistrationModel::class, 'course_event_schedule_id', 'course_event_schedule_id');
    }

    public function courseType()
    {
        return $this->belongsTo(CourseTypeModel::class, 'course_type_id', 'course_type_id');
    }
}
