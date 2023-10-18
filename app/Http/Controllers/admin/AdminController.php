<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BanglaContent;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EnglishContent;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        //Total Book
        $totalBook = Book::count();
        $totalChapter = Chapter::count();
        $totalBanglaLine = BanglaContent::Where('type', '=','text')->count('line');
        $totalEnglishLine = EnglishContent::Where('type', '=','text')->count('line');
        return view('admin.dashboard',compact('totalBook', 'totalChapter', 'totalBanglaLine', 'totalEnglishLine'));
    }
}
