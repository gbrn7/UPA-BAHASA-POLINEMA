<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentModel extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;

    protected $table = 'm_content';
    protected $primaryKey = 'content_id';

    protected $guarded = [];
}
