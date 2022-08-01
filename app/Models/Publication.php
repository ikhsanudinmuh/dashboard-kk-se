<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class publication extends Model
{
    protected $fillable = [
        'year',
        'writer_1_id',
        'writer_2_id',
        'writer_3_id',
        'writer_4_id',
        'writer_5_id',
        'writer_6_id',
        'lab',
        'partner_institution',
        'title',
        'type',
        'journal_conference',
        'journal_accreditation',
        'link',
        'file',
    ];

    use HasFactory;
}
