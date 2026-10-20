<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Promo;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'promos' => Promo::whereDate('start_date', '<=', today())
                ->whereDate('end_date', '>=', today())
                ->orderByDesc('start_date')
                ->get(),
            'categories' => Category::orderBy('sort_order')->get(),
            'featuredMenus' => MenuItem::where('is_available', true)
                ->with('category')
                ->orderByDesc('created_at')
                ->take(4)
                ->get(),
            'galleries' => Gallery::orderByDesc('created_at')->get(),
        ]);
    }
}
