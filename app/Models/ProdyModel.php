<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdyModel extends Model
{
    use HasFactory;
    protected $table = 'm_prody';
    protected $primaryKey = 'prody_id';

    protected $fillable = ([
        'name',
        'departement_id',
        'created_by',
        'updated_by',
        'deleted_by',   
    ]);
}
