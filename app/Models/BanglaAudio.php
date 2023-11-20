<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanglaAudio extends Model
{
    use HasFactory;
    protected $fillable = [
        'chapter_id',
        'file',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class,'chapter_id');
    }


}
