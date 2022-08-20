<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal_accreditation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
