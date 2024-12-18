<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Chapter;

class Book extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name_bn',
        'name_en',
        'total_pages',
        'status',
    ];
}
