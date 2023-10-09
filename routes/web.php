<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BanglaContentController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\admin\ChapterController;
use App\Http\Controllers\admin\ContentController;
use App\Http\Controllers\admin\TextSplitController;


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

    //Bangla Content
    Route::get('/bangla-content-show', [BanglaContentController::class, 'show'])->name('bangla.content.show');
    Route::get('/bangla-content', [BanglaContentController::class, 'index'])->name('bangla.content');
    Route::post('/bangla-content-store', [BanglaContentController::class, 'store'])->name('bangla.content.store');
    Route::put('/bangla-content/update/{id}',[BanglaContentController::class, 'update'])->name('bangla.content.update');
    Route::get('/bangla-content/delete/{id}',[BanglaContentController::class, 'destroy'])->name('bangla.content.delete');



});
require __DIR__.'/auth.php';
