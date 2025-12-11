<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::with(['author','category'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string',
            'author_id'    => 'required|integer|exists:authors,id',
            'category_id'  => 'required|integer|exists:categories,id',
            'release_date' => 'nullable|date',
            'price_huf'    => 'required|integer',
        ]);

        return Book::create($data);
    }

    public function show($id)
    {
        return Book::with(['author','category'])->findOrFail($id);
    }

    public function search(Request $request)
    {
        $q = $request->query('query');

        return Book::with(['author','category'])
            .where('title', 'like', "%$q%")
            .orWhereHas('author', fn($a) => $a->where('name','like',"%$q%"))
            .orWhereHas('category', fn($c) => $c->where('name','like',"%$q%"))
            .get();
    }
}
