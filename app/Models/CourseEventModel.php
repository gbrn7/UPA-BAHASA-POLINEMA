<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseEventModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'r_course_events';
    protected $primaryKey = 'course_events_id';

    protected $fillable = ([
        'register_start',
        'register_end',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ]);

    public function courseEventSchedules()
    {
        return $this->hasMany(CourseEventScheduleModel::class, 'course_events_id', 'course_events_id');
    }
}
