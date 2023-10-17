<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BanglaContent;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EnglishContent;
use Illuminate\Http\Request;
use DB;
class EnglishContentController extends Controller
{
    public function index()
    {
        $books = Book::where('language','=','english')->get();
        $chapters = Chapter::latest()->get();
        $englishContent = EnglishContent::latest()->first();
        $pageNo = $englishContent? $englishContent->page_no : 0;
        return view('admin.pages.content.englishContent', compact('books', 'chapters','pageNo'));
    }
    public function store(Request $request)
    {
        if($request->type == "text") {
            try {
                $english_lines = [];
                foreach(json_decode(request('lines_array'), true) as $line)
                {
                    array_push($english_lines, trim(html_entity_decode($line)));
                }
                if(count($english_lines) != 0)
                {
                    for($i=0; $i<count($english_lines); $i++)
                    {
                        $content = new EnglishContent();
                        $content->type = $request->type;
                        $content->book_id = $request->book_id;
                        $content->chapter_id = $request->chapter_id;
                        $content->line = $english_lines[$i];
                        $content->page_no = $request->page_no;
                        $content->save();
                        $request->session()->flash('success', true);
                    }
                }
                return redirect()->back()->with('success','Content Added Successfully');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            $imageFile = 'image/englishContent';
            if ($request->hasFile('image_file')) {
                $image = $request->file('image_file')->store($imageFile, 'public');
            }
            EnglishContent::create([
                'type' =>  $request->type,
                'book_id' => $request->book_id,
                'chapter_id' =>  $request->chapter_id,
                'page_no' =>  $request->page_no,
                'image_file' => $image ?? null,
            ]);
            return redirect()->back()->with('success','Content Added Successfully');
        }
    }


    public function englishContentShowAll(Request $request)
    {
        $books = Book::where('language','=','english')->get();
        $chapters = Chapter::get();
        $bookId = $request->input('book_id');
        $chapterId = $request->input('chapter_id');
        $query = EnglishContent::where('book_id', $bookId)->where('chapter_id', $chapterId);
        if (!empty($search)) {
            $query->where('text', 'LIKE', '%' . $search . '%');
        }
        $contents = $query
            ->select('page_no','type', DB::raw('COUNT(*) as total_line'))
            ->groupBy('page_no','type',)
            ->get();
        return view('admin.pages.content.englishContentShowFormForFilter', compact('books', 'chapters', 'contents', 'bookId', 'chapterId'));
    }

    public function viewPageEnglish($bookId, $chapterId, $pageNo)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = EnglishContent::where('book_id', $bookId)
            ->where('chapter_id', $chapterId)
            ->where('page_no', $pageNo)
            ->with('book','chapter')
            ->get();
        return view('admin.pages.content.viewEnglishLine', compact('contents', 'books', 'chapters'));
    }

    public function editPageEnglish($bookId, $chapterId, $pageNo)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = EnglishContent::where('book_id', $bookId)
            ->where('chapter_id', $chapterId)
            ->where('page_no', $pageNo)
            ->get();
        $totalLineCount = $contents->count();
        return view('admin.pages.content.editEnglishLine', compact('contents', 'books', 'chapters','totalLineCount'));
    }

    public function editDurationEnglish($bookId, $chapterId, $pageNo)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = EnglishContent::where('book_id', $bookId)
            ->where('chapter_id', $chapterId)
            ->where('page_no', $pageNo)
            ->get();
        $totalLineCount = $contents->count();
        return view('admin.pages.content.editEnglishLineDuration', compact('contents', 'books', 'chapters','totalLineCount'));
    }


    public function updateEnglishPageContent(Request $request)
    {
        $lineIds = $request->input('id');
        $lines = $request->input('line');
        foreach ($lineIds as $key => $lineId) {
            $content = EnglishContent::find($lineId);
            $content->line = $lines[$key];
            $content->save();
        }
        return redirect()->back()->with('success', 'Lines updated successfully');
    }

    public function updateEnglishPageDuration(Request $request)
    {
        $lineIds = $request->input('id');
        $startTimes = $request->input('start_time');
        $endTimes = $request->input('end_time');
        foreach ($lineIds as $key => $lineId) {
            $content = EnglishContent::find($lineId);
            $content->start_time = $startTimes[$key];
            $content->end_time = $endTimes[$key];
            $content->save();
        }
        return redirect()->back()->with('success', 'Lines updated successfully');
    }

}
