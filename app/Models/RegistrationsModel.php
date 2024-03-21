<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationsModel extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 't_registrations';
    protected $primaryKey = 'registration_id';

    protected $fillable = ([
        'activity_id',
        'nim',
        'name',
        'email',
        'phone_num',
        'departement',
        'program_study',
        'created_by',
        'updated_by',
        'deleted_by',
    ]);
}
