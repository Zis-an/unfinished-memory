<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanglaBookReferencePage extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'chapter_id',
        'page_no',
        'reference_page_no',
    ];

    public function reference()
    {
        return $this->hasMany(BanglaContent::class, 'page_no', 'page_no');
    }

}
