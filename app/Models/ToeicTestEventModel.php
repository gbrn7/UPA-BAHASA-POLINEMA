<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToeicTestEventModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'r_toeic_test_events';
    protected $primaryKey = 'toeic_test_events_id';

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

    public function registers()
    {
        return $this->hasMany(ToeicTestRegistrationsModel::class, 'toeic_test_events_id', 'toeic_test_events_id');
    }
}
