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
                'startTime' => $content->start_time,
                'endTime' => $content->end_time,
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

//    public function chapters(Book $book)
//    {
//        $chapters = $book->chapters->map(function ($chapter) use ($book) {
//            $pageCount = BanglaContent::where('book_id', $book->id)
//                ->where('chapter_id', $chapter->id)
//                ->distinct('page_no')
//                ->count('page_no');
//
//            $chapter->page_count = $pageCount;
//
//            return $chapter;
//        });
//
//        return response()->json($chapters);
//    }


    public function chapters(Book $book)
    {
        $startPage = 1; // Initialize the start page number
        $chapters = $book->chapters->map(function ($chapter) use ($book, &$startPage) {
            $pageCount = BanglaContent::where('book_id', $book->id)
                ->where('chapter_id', $chapter->id)
                ->distinct('page_no')
                ->count('page_no');

            $chapter->page_count = $pageCount;
            $endPage = $startPage + $pageCount - 1; // Calculate the end page number

            $chapter->page_range = "$startPage-$endPage"; // Store the page range in the chapter object

            $startPage = $endPage + 1; // Update the start page for the next chapter

            return $chapter;
        });

        return response()->json($chapters);
    }



//    public function content(Book $book, Chapter $chapter)
//    {
//        try {
//            $bookId = $book->id;
//            $chapterId = $chapter->id;
//            $pageNo = request()->input('page_no');
//
//            if ($bookId !== null && $chapterId !== null && $pageNo !== null) {
//                $contents = BanglaContent::where('book_id', $bookId)
//                    ->where('chapter_id', $chapterId)
//                    ->where('page_no', $pageNo)
//                    ->get();
//
//                if ($contents->isEmpty()) {
//                    return response()->json(['message' => 'No content found.']);
//                }
//
//                return response()->json($contents);
//            } else {
//                return response()->json(['message' => 'Invalid input. Please provide valid book, chapter, and page number.']);
//            }
//        } catch (Exception $e) {
//            return response()->json(['message' => 'An error occurred.']);
//        }
//    }

    public function content(Book $book, Chapter $chapter)
    {

        try {
            $bookId = $book->id;
            $chapterId = $chapter->id;
            $pageNo = request()->input('page_no');
            if ($bookId !== null && $chapterId !== null && $pageNo !== null) {
                $contents = BanglaContent::where([
                    'book_id' => $bookId,
                    'chapter_id' => $chapterId,
                    'page_no' => $pageNo,
                ])->get();

                $totalLineCount = $contents->count();
                if ($contents->isEmpty()) {
                    return response()->json(['message' => 'No content found.']);
                }
                return response()->json([
                    'total_lines' => $totalLineCount,
                    'contents' => $contents

                ]);
            }
            return response()->json(['message' => 'Invalid input. Please provide valid book, chapter, and page number.']);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred.']);
        }
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
