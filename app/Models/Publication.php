<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'year',
        'author_1_id',
        'author_2_id',
        'author_3_id',
        'author_4_id',
        'author_5_id',
        'author_6_id',
        'lab',
        'partner_institution',
        'title',
        'publication_type_id',
        'journal_conference',
        'journal_accreditation_id',
        'link',
        'publication_file',
    ];
}
