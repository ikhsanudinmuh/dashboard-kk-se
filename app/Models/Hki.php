<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hki extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'leader_id',
        'member_1_id',
        'member_2_id',
        'member_3_id',
        'patent_type_id',
        'creation_type',
        'title',
        'description',
        'registration_number',
        'sertification_number',
        'hki_file',
    ];
}
