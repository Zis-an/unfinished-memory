<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        return view('admin.pages.book.book',compact('books'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
            ]);
            $book = new Book();
            $book->name = $request->name;
            $book->language = $request->language;
            $book->save();
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
                'name' => 'required|max:255',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $book = Book::findOrFail($id);
            $book->name = $request->input('name');
            $book->status = $request->input('status');
            $book->save();
            Alert::success('Success', 'Book information updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while updating book information');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            Alert::success('Success', 'Book deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while deleting the book');
            return redirect()->route('admin.book')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
