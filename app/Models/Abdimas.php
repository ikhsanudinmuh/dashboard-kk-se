<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abdimas extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'abdimas_type_id',
        'activity_name',
        'title',
        'status',
        'leader_id',
        'member_1_id',
        'member_2_id',
        'member_3_id',
        'member_4_id',
        'member_5_id',
        'lab_id',
        'partner',
        'partner_address',
        'abdimas_file',
    ];
}
