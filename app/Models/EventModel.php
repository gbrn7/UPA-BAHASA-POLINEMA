<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'r_events';
    protected $primaryKey = 'event_id';

    protected $fillable = ([
        'register_start',
        'register_end',
        'execution',
        'quota',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ]);
}
