<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Book CRUD + Search
|--------------------------------------------------------------------------
*/

Route::post('/books', [BookController::class, 'store']);
Route::get('/books/search', [BookController::class, 'search']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::delete('/books/{id}', [BookController::class, 'delete']);

Route::get('/authors/autocomplete', [AuthorController::class, 'autocomplete']);
Route::get('/categories/autocomplete', [CategoryController::class, 'autocomplete']);

/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

Route::get('/statistics/expensive-books',        [StatisticsController::class, 'expensiveBooks']);
Route::get('/statistics/popular-categories',     [StatisticsController::class, 'popularCategories']);
Route::get('/statistics/top-fantasy-and-sci-fi', [StatisticsController::class, 'topFantasyAndSciFi']);
