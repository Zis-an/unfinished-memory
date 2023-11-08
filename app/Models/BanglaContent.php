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
        'start_time',
        'end_time',
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

    public function reference()
    {
        return $this->belongsTo(BanglaBookReferencePage::class, 'page_no', 'page_no');
    }

}
