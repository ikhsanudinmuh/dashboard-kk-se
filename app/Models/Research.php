<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'research_type_id',
        'activity_name',
        'title',
        'status',
        'leader_id',
        'member_1_id',
        'member_2_id',
        'member_3_id',
        'partner',
        'lab_id',
        'research_file',
    ];

    protected $table = 'researchs';
}
