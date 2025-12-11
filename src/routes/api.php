<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Book CRUD + Search
|--------------------------------------------------------------------------
*/

Route::post('/books', [BookController::class, 'store']);
Route::get('/books/search', [BookController::class, 'search']);
Route::get('/books/{id}', [BookController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

Route::get('/statistics/expensive-books',        [StatisticsController::class, 'expensiveBooks']);
Route::get('/statistics/popular-categories',     [StatisticsController::class, 'popularCategories']);
Route::get('/statistics/top-fantasy-and-sci-fi', [StatisticsController::class, 'topFantasyAndSciFi']);
