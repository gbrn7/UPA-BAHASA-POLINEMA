<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartementModel extends Model
{
    use HasFactory;
    protected $table = 'm_departement';
    protected $primaryKey = 'departement_id';

    protected $fillable = ([
        'name'
    ]);

}
