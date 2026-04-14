<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        $query = Portfolio::active();

        if ($category && $category !== 'All') {
            $query->where('category', $category);
        }

        $portfolios = $query->get();
        $categories = Portfolio::active()->distinct()->pluck('category')->sort()->values();

        return view('pages.portfolio', compact('portfolios', 'categories', 'category'));
    }
}
