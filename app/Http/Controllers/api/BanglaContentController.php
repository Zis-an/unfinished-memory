<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BanglaContent;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Http\Request;

class BanglaContentController extends Controller
{
//    public function content($pageNo)
//    {
//        $contents = BanglaContent::where('page_no', $pageNo)->get();
//        $firstContent = $contents->first();
//        $chapter = Chapter::find($firstContent->chapter_id);
//        $book = Book::find($chapter->book_id);
//        $audioPath = public_path("bookBangla/page_{$pageNo}/");
//        try {
//            if (!file_exists($audioPath)) {
//                $contentData = $contents->map(function ($content) {
//                    return [
//                        'id' => $content->id,
//                        'line' => $content->line,
//                        'type' => $content->type,
//                        'startTime' => $content->start_time,
//                        'endTime' => $content->end_time,
//                        'image' => $content->image_file,
//                    ];
//                });
//
//                return response()->json([
//                    'book' => $book,
//                    'chapter' => $chapter,
//                    'lines' => $contentData,
//                    'audio_files' => null,
//                    'pageNo' => $pageNo,
//                    'totalPage' => 50,
//                ]);
//            }
//
//            $audioFiles = array_values(array_diff(scandir($audioPath), ['.', '..']));
//            natsort($audioFiles);
//            $audioFilesAssoc = [];
//            foreach ($audioFiles as $index => $fileName) {
//                $audioFilesAssoc[] = $audioPath . $fileName;
//            }
//
//            $contentData = $contents->map(function ($content) {
//                return [
//                    'id' => $content->id,
//                    'line' => $content->line,
//                    'type' => $content->type,
//                    'image' => $content->image_file,
//                ];
//            });
//
//            return response()->json([
//                'book' => $book,
//                'chapter' => $chapter,
//                'lines' => $contentData,
//                'audio_files' => $audioFilesAssoc,
//                'pageNo' => $pageNo,
//                'totalPage' => 50,
//
//
//            ]);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'An error occurred.'], 500);
//        }
//    }

    public function contentAll($pageNo)
    {
        $contents = BanglaContent::where('page_no', $pageNo)->get();
        $firstContent = $contents->first();
        $chapter = Chapter::find($firstContent->chapter_id);
        $book = Book::find($chapter->book_id);

        $contentData = $contents->map(function ($content) {
            return [
                'id' => $content->id,
                'line' => $content->line,
                'type' => $content->type,
                'image' => $content->image_file,
            ];
        });

        return response()->json([
            'book' => $book,
            'chapter' => $chapter,
            'lines' => $contentData,
            'pageNo' => $pageNo,
            'totalPage' => 50,
        ]);
    }
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function chapters(Book $book)
    {
        $chapters = $book->chapters;
        return response()->json($chapters);
    }
    public function content(Book $book, Chapter $chapter)
    {
        $pageNo = request()->input('page_no');
        $contents = BanglaContent::where('book_id', $book->id)
            ->where('chapter_id', $chapter->id)
            ->where('page_no', $pageNo)
            ->get();
        return response()->json($contents);
    }


//    public function content(Book $book, Chapter $chapter)
//    {
//        $pageNo = request()->input('page_no');
//        $contents = BanglaContent::where('book_id', $book->id)
//            ->where('chapter_id', $chapter->id)
//            ->where('page_no', $pageNo)
//            ->get();
//        $bookInfo = $contents->isEmpty() ? null : $contents->first()->book;
//        $chapterInfo = $contents->isEmpty() ? null : $contents->first()->chapter;
//
//        $response = [
//            'contents' => $contents,
//            'book' => $bookInfo,
//            'chapter' => $chapterInfo,
//        ];
//
//        return response()->json($response);
//    }





}
