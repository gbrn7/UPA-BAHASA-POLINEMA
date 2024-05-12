<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTypeModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_course_type';
    protected $primaryKey = 'course_type_id';

    protected $fillable = ([
        'name',
        'created_by',
        'updated_by',
        'deleted_by',    
    ]);}
