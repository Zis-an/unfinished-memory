<?php

use App\Http\Controllers\api\BanglaContentController;
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

//public api
Route::get('/chapter/page/{pageNo}', [BanglaContentController::class, 'contentAll']);
Route::get('/books',[BanglaContentController::class, 'index']);
Route::get('/books/{book}/chapters',[BanglaContentController::class, 'chapters']);
Route::get('/books/{book}/chapters/{chapter}/content',[BanglaContentController::class, 'content']);

