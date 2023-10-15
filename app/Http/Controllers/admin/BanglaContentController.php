<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BanglaContent;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
class BanglaContentController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $banglaContent = BanglaContent::latest()->first();
        $pageNo = $banglaContent? $banglaContent->page_no : 0;
        return view('admin.pages.content.banglaContent', compact('books', 'chapters','pageNo'));
    }
    public function store(Request $request)
    {
        if($request->type == "text") {
            try {
                $bengali_lines = [];
                foreach(json_decode(request('lines_array'), true) as $line)
                {
                    array_push($bengali_lines, trim(html_entity_decode($line)));
                }
                if(count($bengali_lines) != 0)
                {
                    for($i=0; $i<count($bengali_lines); $i++)
                    {
                        $content = new BanglaContent();
                        $content->type = $request->type;
                        $content->book_id = $request->book_id;
                        $content->chapter_id = $request->chapter_id;
                        $content->line = $bengali_lines[$i];
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
            $imageFile = 'image/banglaContent';
            if ($request->hasFile('image_file')) {
                $image = $request->file('image_file')->store($imageFile, 'public');
            }
            BanglaContent::create([
                'type' =>  $request->type,
                'book_id' => $request->book_id,
                'chapter_id' =>  $request->chapter_id,
                'page_no' =>  $request->page_no,
                'image_file' => $image ?? null,
            ]);
            return redirect()->back()->with('success','Content Added Successfully');
        }
    }

//    public function show()
//    {
//        $books = Book::latest()->get();
//        $chapters = Chapter::latest()->get();
//        $contents = BanglaContent::with('chapter')->latest()->get();
//        return view('admin.pages.content.banglaContentShow', compact('books', 'chapters', 'contents'));
//    }

    public function banglaContentShowAll(Request $request)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $bookId = $request->input('book_id');
        $chapterId = $request->input('chapter_id');
        $query = BanglaContent::where('book_id', $bookId)->where('chapter_id', $chapterId);
        if (!empty($search)) {
            $query->where('text', 'LIKE', '%' . $search . '%');
        }
        $contents = $query
            ->select('page_no','type', DB::raw('COUNT(*) as total_line'))
            ->groupBy('page_no','type',)
            ->get();
        return view('admin.pages.content.bnglaContentShowFormForFilter', compact('books', 'chapters', 'contents', 'bookId', 'chapterId'));
    }

    public function viewPage($bookId, $chapterId, $pageNo)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = BanglaContent::where('book_id', $bookId)
            ->where('chapter_id', $chapterId)
            ->where('page_no', $pageNo)
            ->get();
        return view('admin.pages.content.viewBanglaLine', compact('contents', 'books', 'chapters'));
    }

    public function editPage($bookId, $chapterId, $pageNo)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = BanglaContent::where('book_id', $bookId)
            ->where('chapter_id', $chapterId)
            ->where('page_no', $pageNo)
            ->get();
        return view('admin.pages.content.editBanglaLine', compact('contents', 'books', 'chapters'));
    }

    public function editDuration($bookId, $chapterId, $pageNo)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = BanglaContent::where('book_id', $bookId)
            ->where('chapter_id', $chapterId)
            ->where('page_no', $pageNo)
            ->get();
        return view('admin.pages.content.editLineDuration', compact('contents', 'books', 'chapters'));
    }


    public function updatePageContent(Request $request)
    {
        $lineIds = $request->input('id');
        $lines = $request->input('line');
        foreach ($lineIds as $key => $lineId) {
            // Assuming you have a model for your content, retrieve the content by ID
            $content = BanglaContent::find($lineId);
            // Update the content with the new data
            $content->line = $lines[$key];
            // Save the updated content
            $content->save();
        }
        return redirect()->back()->with('success', 'Lines updated successfully');
    }

    public function updatePageDuration(Request $request)
    {
        $lineIds = $request->input('id');
        $startTimes = $request->input('start_time');
        $endTimes = $request->input('end_time');
        foreach ($lineIds as $key => $lineId) {
            $content = BanglaContent::find($lineId);
            // Update the content with the new data
            $content->start_time = $startTimes[$key];
            $content->end_time = $endTimes[$key];
            $content->save();
        }
        return redirect()->back()->with('success', 'Lines updated successfully');
    }

}
