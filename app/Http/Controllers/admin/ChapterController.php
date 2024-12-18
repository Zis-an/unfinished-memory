<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ChapterController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        $chapters = Chapter::with('book')->latest()->get();
        return view('admin.pages.chapter.chapter',compact('books','chapters'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required',
                'chapter_name_en' => 'required',
                'chapter_name_bn' => 'required',
            ]);
            $chapter = new Chapter();
            $chapter->book_id = $request->book_id;
            $chapter->chapter_name_en = $request->chapter_name_en;
            $chapter->chapter_name_bn = $request->chapter_name_bn;
            $chapter->total_pages = $request->total_pages;
            $chapter->save();
            $request->session()->flash('success', true);
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    //update
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'book_id' => 'required',
                'chapter_name_en' => 'required',
                'chapter_name_bn' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $chapter = Chapter::findOrFail($id);
            $chapter->book_id = $request->input('book_id');
            $chapter->chapter_name_en = $request->input('chapter_name_en');
            $chapter->chapter_name_bn = $request->input('chapter_name_bn');
            $chapter->total_pages = $request->input('total_pages');
            $chapter->status = $request->input('status');
            $chapter->save();
            Alert::success('Success', 'Chapter information updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while updating chapter information');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $chapter = Chapter::findOrFail($id);
            $chapter->delete();
            Alert::success('Success', 'Chapter deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while deleting the Chapter');
            return redirect()->route('admin.chapter')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}