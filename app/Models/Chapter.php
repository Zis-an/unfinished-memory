<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'book_id',
        'chapter_name',
        'status',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function contentsBangla()
    {
        return $this->hasMany(BanglaContent::class);
    }


    public function contentsEnglish()
    {
        return $this->hasMany(EnglishContent::class);
    }

    public function banglaAudio()
    {
        return $this->hasOne(BanglaAudio::class);
    }

    public function englishAudio()
    {
        return $this->hasOne(EnglishAudio::class);
    }

}
