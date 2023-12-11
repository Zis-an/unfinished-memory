<?php

use App\Http\Controllers\api\ArchieveController;
use App\Http\Controllers\api\BanglaContentController;
use App\Http\Controllers\api\EnglishContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public api for bangla content
Route::get('/chapter/page/{pageNo}', [BanglaContentController::class, 'contentAll']);
Route::get('/books',[BanglaContentController::class, 'index']);
Route::get('/books/{book}/chapters',[BanglaContentController::class, 'chapters']);
Route::get('/books/{book}/chapters/{chapter}/content',[BanglaContentController::class, 'content']);
Route::get('/books/{book}/chapters/{chapter}/all-content', [BanglaContentController::class, 'chapterContent']);
Route::get('/search',[BanglaContentController::class, 'searchByLine']);
Route::get('/books/{book}/chapters/{chapter}/all-pages', [BanglaContentController::class, 'chapterContentPages']);

//public api for english content
Route::get('/english-chapter/page/{pageNo}', [EnglishContentController::class, 'contentAll']);
Route::get('/english-books',[EnglishContentController::class, 'index']);
Route::get('/english-books/{book}/chapters',[EnglishContentController::class, 'chapters']);
Route::get('/english-books/{book}/chapters/{chapter}/content',[EnglishContentController::class, 'content']);
Route::get('/english-books/{book}/chapters/{chapter}/all-content', [EnglishContentController::class, 'chapterContent']);
Route::get('/english-search',[EnglishContentController::class, 'searchByLine']);
Route::get('/english-books/{book}/chapters/{chapter}/all-pages', [EnglishContentController::class, 'chapterContentPages']);
Route::get('/archive',[ArchieveController::class, 'index']);

//Route::get('/chapter/page/{pageNo}', [EnglishContentController::class, 'contentAll']);
//Route::get('/books',[EnglishContentController::class, 'index']);
//Route::get('/books/{book}/chapters',[EnglishContentController::class, 'chapters']);
//Route::get('/books/{book}/chapters/{chapter}/content',[EnglishContentController::class, 'content']);
//Route::get('/books/{book}/chapters/{chapter}/all-content', [EnglishContentController::class, 'chapterContent']);
//Route::get('/english-search',[EnglishContentController::class, 'searchByLine']);
//Route::get('/books/{book}/chapters/{chapter}/all-pages', [EnglishContentController::class, 'chapterContentPages']);
//Route::get('/archive',[ArchieveController::class, 'index']);
