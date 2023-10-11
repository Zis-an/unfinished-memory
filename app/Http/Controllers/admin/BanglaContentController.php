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

//                dd(json_decode(request('lines_array'), true));

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

                return redirect()->route('bangla.content.show')->with('success','Content Added Successfully');

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
            return redirect()->route('bangla.content.show')->with('success','Content Added Successfully');
        }
    }

    public function show()
    {
        $books = Book::latest()->get();
        $chapters = Chapter::latest()->get();
        $contents = BanglaContent::with('chapter')->latest()->get();
        return view('admin.pages.content.banglaContentShow', compact('books', 'chapters', 'contents'));
    }


    public function update(Request $request, $id)
    {

        try {
            $validator = Validator::make($request->all(), [
                'book_id' => 'required',
                'chapter_id' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $banglaContent = BanglaContent::findOrFail($id);
            $banglaContent->book_id = $request->book_id;
            $banglaContent->chapter_id = $request->chapter_id;
            $banglaContent->line = $request->line;
            if($request->hasFile('image_file'))
            {
                $imagePath = $request->file('image_file')->store('public/images');
                $banglaContent->image_file = $imagePath;
                Storage::delete($banglaContent->image_file);
            }
            $banglaContent->save();
            return redirect()->route('bangla.content.show')->with('success','Content Added Successfully');

        } catch (\Exception $e) {
            return redirect()->route('bangla.content.show')->with('error','Content Delete Successfully');
        }
    }

    public function destroy($id)
    {
        try {
            $banglaContent = BanglaContent::findOrFail($id);
            $banglaContent->delete();
            Storage::delete($banglaContent->image_file);
            return redirect()->route('bangla.content.show')->with('success','Content Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->route('bangla.content.show')->with('error','Content not Deleted');
        }
    }
}
