<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use App\Enums\CategoryNames;

class StatisticsService
{
    public function expensiveBooks()
    {
        $avg = Book::avg('price_huf');

        return Book::with(['author', 'category'])
            ->where('price_huf', '>', $avg)
            ->get();
    }

    public function popularCategories()
    {
        return Book::select(
            'categories.name',
            DB::raw('ROUND(AVG(books.price_huf), 0) as avg_price')
        )
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByRaw('COUNT(books.id) DESC')
            ->limit(3)
            ->get();
    }

    public function topFantasyAndSciFi()
    {
        $sub = DB::table('books')
            ->select(
                'books.*',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY categories.name ORDER BY books.price_huf DESC) as rn')
            )
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->whereIn('categories.name', [
                CategoryNames::FANTASY,
                CategoryNames::SCI_FI,
            ]);

        return Book::fromSub($sub, 't')
            ->where('rn', '<=', 3)
            ->with(['author', 'category'])
            ->selectRaw('t.*, ROUND(t.price_huf, 0) as price_huf')
            ->get();
    }
}
