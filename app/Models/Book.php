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
        'name',
        'language',
        'status',
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
