<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'r_events';
    protected $primaryKey = 'event_id';

    protected $fillable = ([
        'register_start',
        'register_end',
        'execution', 
        'quota',
        'remaining_quota',
        'status',
        'wa_group_link',
        'created_by',
        'updated_by',
        'deleted_by',
    ]);
}
