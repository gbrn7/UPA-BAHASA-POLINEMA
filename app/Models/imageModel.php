<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class imageModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_image';
    protected $primaryKey = 'image_id';

    protected $fillable = ([
        'file_name',
        'type',
        'created_by',
        'updated_by',
        'deleted_by',    
    ]);
}
