<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archieve extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_bn',
        'photo',
    ];

}
