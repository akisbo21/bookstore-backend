<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function store(Request $request)
    {
        return $this->bookService->store($request);
    }

    public function show(int $id)
    {
        return $this->bookService->show($id);
    }

    public function search(Request $request)
    {
        return $this->bookService->searchWithExchangeRate($request);
    }

    public function delete(int $id)
    {
        return $this->bookService->delete($id);
    }
}
