<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function autocomplete(Request $request)
    {
        $q = (string) $request->query('query', '');

        return Author::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->limit(20)
            ->get();
    }
}
