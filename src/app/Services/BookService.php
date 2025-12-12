<?php

namespace App\Services;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookService
{
    private ExchangeRateService $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function store(Request $request): Book
    {
        $data = $request->validate([
            'id' => 'nullable|integer|exists:books,id',
            'title' => 'required|string',
            'author_id' => 'required|integer|exists:authors,id',
            'category_id' => 'required|integer|exists:categories,id',
            'release_date' => 'nullable|date',
            'price_huf' => 'required|integer',
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

    public function show(int $id): Book
    {
        return Book::with(['author', 'category'])->findOrFail($id);
    }

    public function search(Request $request)
    {
        $q = (string) $request->query('query', '');

        return Book::with(['author', 'category'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhereHas('author', function ($a) use ($q) {
                        $a->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('category', function ($c) use ($q) {
                        $c->where('name', 'like', "%{$q}%");
                    });
            })
            ->get();
    }

    public function searchWithExchangeRate(Request $request)
    {
        $books = $this->search($request);

        $rate = $this->exchangeRateService->fetchEurHuf()['rate'];

        return $books->map(function ($book) use ($rate) {
            $book->price_eur = round($book->price_huf / $rate, 2);
            return $book;
        });
    }

    public function delete(int $id): bool
    {
        return Book::findOrFail($id)->delete();
    }
}
