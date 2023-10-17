<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnglishContent extends Model
{
    use HasFactory;


    protected $fillable = [
        'type',
        'book_id',
        'chapter_id',
        'line',
        'page_no',
        'image_file'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}
