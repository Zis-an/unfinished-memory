<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        //Total Book
        $totalBook = Book::count();
        $totalChapter = Chapter::count();
        $totalImage = 10;
        $totalLine = 60;
        return view('admin.dashboard',compact('totalBook', 'totalChapter', 'totalImage', 'totalLine'));
    }
}
