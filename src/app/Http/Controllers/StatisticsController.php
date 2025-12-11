<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function expensiveBooks()
    {
        $avg = Book::avg('price_huf');
        return Book::where('price_huf', '>', $avg)->get();
    }

    public function popularCategories()
    {
        return DB::table('books')
            ->join('categories','categories.id','=','books.category_id')
            ->select('categories.name', DB::raw('AVG(price_huf) as avg_price'))
            ->groupBy('categories.name')
            ->orderByDesc(DB::raw('COUNT(*)'))
            ->limit(3)
            ->get();
    }

    public function topFantasyAndSciFi()
    {
        return Book::with(['author','category'])
            ->whereHas('category', fn($q) =>
            $q->whereIn('name', ['Fantasy','Sci-fi'])
            )
            ->orderByDesc('price_huf')
            ->limit(6)
            ->get();
    }
}
