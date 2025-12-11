<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'id'           => 'nullable|integer|exists:books,id',
            'title'        => 'required|string',
            'author_id'    => 'required|integer|exists:authors,id',
            'category_id'  => 'required|integer|exists:categories,id',
            'release_date' => 'nullable|date',
            'price_huf'    => 'required|integer',
        ]);

        if (!empty($data['release_date'])) {
            $data['release_date'] = Carbon::parse($data['release_date'])->toDateString();
        }

        if (!empty($data['id'])) {
            $book = Book::findOrFail($data['id']);
            $book->update($data);
            return $book;
        }

        return Book::create($data);
    }

    public function show($id)
    {
        return Book::with(['author','category'])->findOrFail($id);
    }

    public function search(Request $request)
    {
        $q = $request->query('query', '');

        return Book::with(['author','category'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                    ->orWhereHas('author', fn($a) => $a->where('name', 'like', "%$q%"))
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%$q%"));
            })
            ->get();
    }
}
