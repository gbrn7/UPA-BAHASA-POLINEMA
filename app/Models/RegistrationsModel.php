<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationsModel extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 't_registrations';

    protected $fillable = ([
        'activity_id',
        'nim',
        'name',
        'email',
        'activity_id',
        'activity_id',
        'activity_id',
        'activity_id',
        'activity_id',
        'activity_id',
    ]);
}
