<?php

namespace App\Models;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function english_chapters()
    {
        return $this->hasMany(EngChapter::class);
    }
}
