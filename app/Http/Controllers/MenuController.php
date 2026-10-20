<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $categoryId = $request->integer('kategori');

        return view('menu.index', [
            'categories' => Category::orderBy('sort_order')->get(),
            'menus' => MenuItem::where('is_available', true)
                ->with('category')
                ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
                ->get(),
            'activeCategory' => $categoryId ?: null,
        ]);
    }

    public function show(int $id): View
    {
        $menu = MenuItem::where('is_available', true)
            ->with('category')
            ->findOrFail($id);

        return view('menu.show', [
            'menu' => $menu,
        ]);
    }
}
