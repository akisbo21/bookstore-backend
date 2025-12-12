<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function autocomplete(Request $request)
    {
        $q = (string) $request->query('query', '');

        return Category::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->limit(20)
            ->get();
    }
}
