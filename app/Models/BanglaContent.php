<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanglaContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'book_id',
        'chapter_id',
        'line',
        'page_no',
        'audio_file',
        'image_file'
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}
