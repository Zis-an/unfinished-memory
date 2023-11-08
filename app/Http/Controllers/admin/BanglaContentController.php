<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BanglaBookReferencePage;
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
        $books = Book::where('language','=','bangla')->get();
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

    public function banglaContentShowAll(Request $request)
    {
        $books = Book::where('language','=','bangla')->get();
        $chapters = Chapter::get();
        $bookId = $request->input('book_id',);
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
            ->with('book','chapter')
            ->get();
        return view('admin.pages.content.viewBanglaLine', compact('contents', 'books', 'chapters'));
    }

//    public function createReferencePageBangla(Request $request,$bookId, $chapterId, $pageNo)
//    {
//        if($request->isMethod('POST'))
//        {
//            try {
//                $data= new BanglaBookReferencePage();
//                $data->book_id = $bookId;
//                $data->chapter_id = $chapterId;
//                $data->page_no = $pageNo;
//                $data->reference_page_no = $request->reference_page_no;
//                $data->save();
//                return redirect()->back()->with('success','Page No Added Successfully');
//            }
//            catch (\Exception $e){
//                return redirect()->back()->with('error','Something went wrong');
//            }
//        }
//        else
//        {
//            $book = Book::where('id',$bookId)->pluck('name')->first();;
//            $chapter = Chapter::where('id',$chapterId)->pluck('chapter_name')->first();;
//            $contents = BanglaContent::where('page_no', $pageNo)->pluck('line');
//            $pageContents =$contents->implode('');
//            $referencePageNo = BanglaBookReferencePage::where('book_id',$bookId)
//                ->where('chapter_id',$chapterId)
//                ->where('page_no',$pageNo)
//                ->pluck('reference_page_no')->first();
//            return view('admin.pages.reference.banglaReferencePageNo',compact('book','bookId',
//                'chapter','chapterId','pageContents','pageNo','referencePageNo'));
//        }
//    }

    public function createReferencePageBangla(Request $request, $bookId, $chapterId, $pageNo)
    {
        if ($request->isMethod('POST')) {
            try {
                BanglaBookReferencePage::updateOrCreate(
                    ['book_id' => $bookId, 'chapter_id' => $chapterId, 'page_no' => $pageNo],
                    ['reference_page_no' => $request->reference_page_no]
                );

                return redirect()->back()->with('success', 'Page No Added/Updated Successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            $book = Book::where('id', $bookId)->pluck('name')->first();
            $chapter = Chapter::where('id', $chapterId)->pluck('chapter_name')->first();
            $contents = BanglaContent::where('page_no', $pageNo)->pluck('line');
            $pageContents = $contents->implode('');
            $referencePageNo = BanglaBookReferencePage::where('book_id', $bookId)
                ->where('chapter_id', $chapterId)
                ->where('page_no', $pageNo)
                ->pluck('reference_page_no')
                ->first();

            return view('admin.pages.reference.banglaReferencePageNo', compact('book', 'bookId', 'chapter', 'chapterId', 'pageContents', 'pageNo', 'referencePageNo'));
        }
    }




    public function editPage($bookId, $chapterId, $pageNo)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = BanglaContent::where('book_id', $bookId)
            ->where('chapter_id', $chapterId)
            ->where('page_no', $pageNo)
            ->get();
        $totalLineCount = $contents->count();
        return view('admin.pages.content.editBanglaLine', compact('contents', 'books', 'chapters','totalLineCount'));
    }

    public function editDuration($bookId, $chapterId, $pageNo)
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = BanglaContent::where('book_id', $bookId)
            ->where('chapter_id', $chapterId)
            ->where('page_no', $pageNo)
            ->get();
        $totalLineCount = $contents->count();
        return view('admin.pages.content.editLineDuration', compact('contents', 'books', 'chapters','totalLineCount'));
    }


    public function updatePageContent(Request $request)
    {
        $lineIds = $request->input('id');
        $lines = $request->input('line');
        foreach ($lineIds as $key => $lineId) {
            $content = BanglaContent::find($lineId);
            $content->line = $lines[$key];
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
            $content->start_time = $startTimes[$key];
            $content->end_time = $endTimes[$key];
            $content->save();
        }
        return redirect()->back()->with('success', 'Lines updated successfully');
    }



}
