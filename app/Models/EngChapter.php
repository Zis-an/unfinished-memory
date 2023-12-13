<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngChapter extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'book_id',
        'chapter_name',
        'total_pages',
        'status',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function contentsEnglish()
    {
        return $this->hasMany(EnglishContent::class);
    }
    public function englishAudio()
    {
        return $this->hasOne(EnglishAudio::class);
    }

}
