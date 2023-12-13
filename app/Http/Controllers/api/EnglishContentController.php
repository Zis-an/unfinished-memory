<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BanglaAudio;
use App\Models\BanglaBookReferencePage;
use App\Models\BanglaContent;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\EngChapter;
use App\Models\EnglishAudio;
use App\Models\EnglishBookReferencePage;
use App\Models\EnglishContent;
use Exception;
use Illuminate\Http\Request;

class EnglishContentController extends Controller
{
    public function searchByLine(Request $request)
    {
        $line = $request->input('line');
        $results = EnglishContent::where('line', 'like', "%$line%")->with('english_chapters','reference','english_chapters.englishAudio')->paginate(10);
        return response()->json($results);
    }

    public function contentAll($pageNo)
    {
        $contents = EnglishContent::where('page_no', $pageNo)->get();
        $firstContent = $contents->first();
        $chapter = EngChapter::find($firstContent->chapter_id);
        $book = Book::find($chapter->book_id);

        // Extract start times and end times into separate arrays
        $startTimes = $contents->pluck('start_time')->map(function ($time) {
            list($minutes, $seconds, $milliseconds) = sscanf($time, "%d:%d:%d");
            return $minutes * 60000 + $seconds * 1000 + $milliseconds;
        })->toArray();

        $endTimes = $contents->pluck('end_time')->map(function ($time) {
            list($minutes, $seconds, $milliseconds) = sscanf($time, "%d:%d:%d");
            return $minutes * 60000 + $seconds * 1000 + $milliseconds;
        })->toArray();

        $referencePageNo = EnglishBookReferencePage::where('page_no',$pageNo)
            ->pluck('reference_page_no')->first();


        $contentData = $contents->map(function ($content) {
            return [
                'id' => $content->id,
                'line' => $content->line,
                'page_no' => $content->page_no,
                'type' => $content->type,
                'startTime' => $content->start_time,
                'endTime' => $content->end_time,
                'image' => $content->image_file,
            ];
        });

        return response()->json([
            'book' => $book,
            'chapter' => $chapter,
            'reference_page_no'=>$referencePageNo,
            'lines' => $contentData,
            'startTime' => $startTimes,
            'endTime' => $endTimes,
            'pageNo' => $pageNo,
            'totalPage' => 187,

        ]);
    }


    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }



//    public function chapters(Book $book)
//    {
//        $startPage = 1; // Initialize the start page number
//        $chapters = $book->chapters->map(function ($chapter) use ($book, &$startPage) {
//            $pageCount = EnglishContent::where('book_id', $book->id)
//                ->where('chapter_id', $chapter->id)
//                ->distinct('page_no')
//                ->count('page_no');
//
//            $endPage = $startPage + $pageCount - 1; // Calculate the end page number
//
//            $chapter->page_count = $pageCount;
//            $chapter->page_range = "$startPage-$endPage"; // Store the page range in the chapter object
//
//            // Create an array of page numbers within the page range
//            $pageNumbers = range($startPage, $endPage);
//            $chapter->page_numbers = $pageNumbers;
//
//            $audioFile = EnglishAudio::where('chapter_id', $chapter->id)->value('file');
//            $chapter->audio_file = $audioFile;
//
//            $startPage = $endPage + 1; // Update the start page for the next chapter
//
//            return $chapter;
//        });
//
//        $perPage = 10;
//        $currentPage = request()->input('page', 1);
//        $pagedData = $chapters->slice(($currentPage - 1) * $perPage, $perPage)->all();
//        $chapters = new \Illuminate\Pagination\LengthAwarePaginator($pagedData, count($chapters), $perPage);
//
//        return response()->json($chapters);
//    }

//    public function chapters(Book $book)
//    {
//        // Assuming $perPage is the number of items you want per page
//        $perPage = 10; // You can adjust this based on your needs
//        $chapters = $book->chapters()->paginate($perPage);
//        $chapters->getCollection()->transform(function ($chapter) use ($book) {
//            $pageCount = EnglishContent::where('book_id', $book->id)
//                ->where('chapter_id', $chapter->id)
//                ->distinct('page_no')
//                ->count('page_no');
//            $endPage = $chapter->page + $pageCount - 1;
//            $chapter->page_count = $pageCount;
//            $chapter->page_range = "{$chapter->page}-$endPage";
//            $pageNumbers = range($chapter->page, $endPage);
//            $chapter->page_numbers = $pageNumbers;
//            $audioFile = EnglishAudio::where('chapter_id', $chapter->id)->value('file');
//            $chapter->audio_file = $audioFile;
//            return $chapter;
//        });
//
//        return response()->json($chapters);
//    }


    public function chapters(Book $book)
    {
        $perPage =10;
        $chapters = $book->english_chapters()->paginate($perPage);
        $chapters->getCollection()->transform(function ($chapter) use ($book, $chapters, $perPage) {
            $currentPage = $chapters->currentPage();
            $pageCount = EnglishContent::where('book_id', $book->id)
                ->where('chapter_id', $chapter->id)
                ->distinct('page_no')
                ->count('page_no');
            $startPage = ($currentPage - 1) * $perPage + 1;
            $endPage = $startPage + $pageCount - 1;
            $chapter->page_count = $pageCount;
            $chapter->page_range = "$startPage-$endPage";
            $pageNumbers = range($startPage, $endPage);
            $chapter->page_numbers = $pageNumbers;
            $audioFile = EnglishAudio::where('chapter_id', $chapter->id)->value('file');
            $chapter->audio_file = $audioFile;
            return $chapter;
        });
        return response()->json($chapters);
    }


    public function content(Book $book, EngChapter $chapter)
    {
        try {
            $bookId = $book->id;
            $chapterId = $chapter->id;



            $pageNo = request()->input('page_no');
            if ($bookId !== null && $chapterId !== null && $pageNo !== null) {
                $contents = EnglishContent::where([
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
                    'contents' => $contents,


                ]);
            }
            return response()->json(['message' => 'Invalid input. Please provide valid book, chapter, and page number.']);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred.']);
        }
    }


    public function chapterContent(Book $book, EngChapter $chapter)
    {
        try {
            $bookId = $book->id;
            $chapterId = $chapter->id;

            if ($bookId !== null && $chapterId !== null) {
                $contents = EnglishContent::where([
                    'book_id' => $bookId,
                    'chapter_id' => $chapterId,
                ])->get();

                // Extract start times and end times into separate arrays
                $startTimes = $contents->pluck('start_time')->map(function ($time) {
                    list($minutes, $seconds, $milliseconds) = sscanf($time, "%d:%d:%d");
                    return $minutes * 60000 + $seconds * 1000 + $milliseconds;
                })->toArray();

                $endTimes = $contents->pluck('end_time')->map(function ($time) {
                    list($minutes, $seconds, $milliseconds) = sscanf($time, "%d:%d:%d");
                    return $minutes * 60000 + $seconds * 1000 + $milliseconds;
                })->toArray();

                $totalLineCount = $contents->count();
                if ($contents->isEmpty()) {
                    return response()->json(['message' => 'No content found.']);
                }

                $referencePageNo = EnglishBookReferencePage::where('chapter_id',$chapterId)->get();



                return response()->json([
                    'total_lines' => $totalLineCount,
                    'reference_page_no' => $referencePageNo,
                    'contents' => $contents,
                    'startTime' => $startTimes,
                    'endTime' => $endTimes,
                ]);
            }

            return response()->json(['message' => 'Invalid input. Please provide a valid book and chapter.']);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred.']);
        }
    }


//    public function chapterContentPages(Book $book, Chapter $chapter)
//    {
//        try {
//            $bookId = $book->id;
//            $chapterId = $chapter->id;
//
//            if ($bookId !== null && $chapterId !== null) {
//                $contents = BanglaContent::where([
//                    'book_id' => $bookId,
//                    'chapter_id' => $chapterId,
//                ])->get();
//
//                $totalLineCount = $contents->count();
//                if ($contents->isEmpty()) {
//                    return response()->json(['message' => 'No content found.']);
//                }
//
//                $formattedContent = [];
//
//                foreach ($contents as $content) {
//                    $pageNo = $content->page_no;
//
//                    if (!isset($formattedContent[$pageNo])) {
//                        $formattedContent[$pageNo] = [
//                            'total_line' => 0,
//                            'page_number' => $pageNo,
//                            'data' => [],
//                            'start_time' => [],
//                            'end_time' => [],
//                        ];
//                    }
//
//                    $formattedContent[$pageNo]['data'][] = [
//                        'id' => $content->id,
//                        'book_id' => $content->book_id,
//                        'chapter_id' => $content->chapter_id,
//                        'type' => $content->type,
//                        'line' => $content->line,
//                        'page_no' => $content->page_no,
//                        'start_time' => $content->start_time,
//                        'end_time' => $content->end_time,
//                        'image_file' => $content->image_file,
//                        'created_at' => $content->created_at,
//                        'updated_at' => $content->updated_at,
//                    ];
//
//                    $startTime = $content->start_time;
//                    $endTime = $content->end_time;
//
//                    if (!is_null($startTime)) {
//                        list($minutes, $seconds, $milliseconds) = sscanf($startTime, "%d:%d:%d");
//                        $formattedStartTime = $minutes * 60000 + $seconds * 1000 + $milliseconds;
//                        $formattedContent[$pageNo]['start_time'][] = $formattedStartTime;
//                    } else {
//                        $formattedContent[$pageNo]['start_time'][] = null;
//                    }
//
//                    if (!is_null($endTime)) {
//                        list($minutes, $seconds, $milliseconds) = sscanf($endTime, "%d:%d:%d");
//                        $formattedEndTime = $minutes * 60000 + $seconds * 1000 + $milliseconds;
//                        $formattedContent[$pageNo]['end_time'][] = $formattedEndTime;
//                    } else {
//                        $formattedContent[$pageNo]['end_time'][] = null;
//                    }
//
//                    $formattedContent[$pageNo]['total_line']++;
//                }
//
//                if (empty($formattedContent)) {
//                    return response()->json(['message' => 'No content found.']);
//                }
//
//                return response()->json([
//                    'contents' => array_values($formattedContent), // Reindex the array
//                ]);
//
//            }
//
//            return response()->json(['message' => 'Invalid input. Please provide a valid book and chapter.']);
//        } catch (Exception $e) {
//            return response()->json(['message' => 'An error occurred.']);
//        }
//    }
    public function chapterContentPages(Book $book, EngChapter $chapter)
    {
        try {
            $bookId = $book->id;
            $chapterId = $chapter->id;
            $chapter = EngChapter::where('id', $chapterId)->pluck('chapter_name')->first();
            $chapterAudio = EnglishAudio::where('chapter_id', $chapterId)->pluck('file')->first();



            if ($bookId !== null && $chapterId !== null) {
                $contents = EnglishContent::where([
                    'book_id' => $bookId,
                    'chapter_id' => $chapterId,
                ])->get();






                $totalLineCount = $contents->count();
                if ($contents->isEmpty()) {
                    return response()->json(['message' => 'No content found.']);
                }


                $formattedContent = [];
                $startPageNo = null;

                foreach ($contents as $content) {
                    $pageNo = $content->page_no;

                    if ($startPageNo === null) {
                        $startPageNo = $pageNo; // Set the start page number
                    }



                    $referencePageNo = EnglishBookReferencePage::where('page_no',$pageNo)
                        ->pluck('reference_page_no')->first();



                    if (!isset($formattedContent[$pageNo])) {
                        $formattedContent[$pageNo] = [
                            'total_line' => 0,
                            'page_number' => $pageNo,
                            'reference_page_number' => $referencePageNo,
                            'data' => [],
                            'start_time' => [],
                            'end_time' => [],
                            'lines' => [], // Added 'lines' array
                        ];
                    }



                    $formattedContent[$pageNo]['data'][] = [
                        'id' => $content->id,
                        'book_id' => $content->book_id,
                        'chapter_id' => $content->chapter_id,
                        'type' => $content->type,
                        'line' => $content->line,
                        'page_no' => $content->page_no,
                        'start_time' => $content->start_time,
                        'end_time' => $content->end_time,
                        'image_file' => $content->image_file,
                        'created_at' => $content->created_at,
                        'updated_at' => $content->updated_at,
                    ];

                    $formattedContent[$pageNo]['lines'][] = $content->line; // Add the 'line' to the 'lines' array

                    $startTime = $content->start_time;
                    $endTime = $content->end_time;

                    if (!is_null($startTime)) {
                        list($minutes, $seconds, $milliseconds) = sscanf($startTime, "%d:%d:%d");
                        $formattedStartTime = $minutes * 60000 + $seconds * 1000 + $milliseconds;
                        $formattedContent[$pageNo]['start_time'][] = $formattedStartTime;
                    } else {
                        $formattedContent[$pageNo]['start_time'][] = null;
                    }

                    if (!is_null($endTime)) {
                        list($minutes, $seconds, $milliseconds) = sscanf($endTime, "%d:%d:%d");
                        $formattedEndTime = $minutes * 60000 + $seconds * 1000 + $milliseconds;
                        $formattedContent[$pageNo]['end_time'][] = $formattedEndTime;
                    } else {
                        $formattedContent[$pageNo]['end_time'][] = null;
                    }

                    $formattedContent[$pageNo]['total_line']++;
                }

                if (empty($formattedContent)) {
                    return response()->json(['message' => 'No content found.']);
                }
                //$lastPageNo = max(array_keys($formattedContent));
                $lastPageNo = "" . max(array_keys($formattedContent));
                return response()->json([
                    'startPageNo' => $startPageNo,
                    'lastPageNo' => $lastPageNo,
                    'chapter_name' => $chapter,
                    'chapter_audio' => "storage/audio/audioBanglaFile/".$chapterAudio,
                    'contents' => array_values($formattedContent),
                ]);
            }

            return response()->json(['message' => 'Invalid input. Please provide a valid book and chapter.']);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred.']);
        }
    }


}
