<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BanglaContentController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\admin\ChapterController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
    //Book
    Route::get('/book',[BookController::class, 'index'])->name('book');
    Route::post('/book/store',[BookController::class, 'store'])->name('book.store');
    Route::put('/book/update/{id}',[BookController::class, 'update'])->name('book.update');
    Route::get('/book/delete/{id}',[BookController::class, 'destroy'])->name('book.delete');

    //Chapter
    Route::get('/chapter',[ChapterController::class, 'index'])->name('chapter');
    Route::post('/chapter/store',[ChapterController::class, 'store'])->name('chapter.store');
    Route::put('/chapter/update/{id}',[ChapterController::class, 'update'])->name('chapter.update');
    Route::get('/chapter/delete/{id}',[ChapterController::class, 'destroy'])->name('chapter.delete');

    //Bangla Content Store
    //Route::get('/bangla-content-show', [BanglaContentController::class, 'show'])->name('bangla.content.show');
    Route::get('/bangla-content', [BanglaContentController::class, 'index'])->name('bangla.content');
    Route::post('/bangla-content-store', [BanglaContentController::class, 'store'])->name('bangla.content.store');

    //Bangla Content Show & Update
    Route::match(['get', 'post'], 'bangla-contents-show-all', [BanglaContentController::class, 'banglaContentShowAll'])->name('bangla.contents.show.all');
    Route::get('/view-content/{bookId}/{chapterId}/{pageNo}/', [BanglaContentController::class, 'viewPage'])->name('view.content');
    Route::get('/edit-content/{bookId}/{chapterId}/{pageNo}/', [BanglaContentController::class, 'editPage'])->name('edit.content');
    Route::get('/edit-duration/{bookId}/{chapterId}/{pageNo}/', [BanglaContentController::class, 'editDuration'])->name('edit.duration');
    Route::put('/update-content', [BanglaContentController::class, 'updatePageContent'])->name('update.content');
    Route::put('/update-duration', [BanglaContentController::class, 'updatePageDuration'])->name('update.duration');
});
require __DIR__.'/auth.php';
