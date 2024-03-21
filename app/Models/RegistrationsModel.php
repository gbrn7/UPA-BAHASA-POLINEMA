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
        'event_id',
        'name',
        'nim',
        'nik',
        'departement',
        'program_study',
        'semester',
        'email',
        'phone_num',
        'ktp_img',
        'ktm_img',
        'surat_pernyataan_iisma',
        'pasFoto_img',
        'created_by',
        'updated_by',
        'deleted_by',
    ]);
}
