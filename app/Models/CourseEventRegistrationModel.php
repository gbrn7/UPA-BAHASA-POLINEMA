<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseEventRegistrationModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't_course_event_registrations';
    protected $primaryKey = 'course_event_registrations_id';

    protected $fillable = ([
        'course_event_schedule_id',
        'name',
        'email',
        'phone_num',
        'address',
        'goal',
        'experience',
        'ktp_or_passport_img',
        'created_by',
        'updated_by',
        'deleted_by',
    ]);}
