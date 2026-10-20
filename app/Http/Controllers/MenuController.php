<?php

namespace App\Http\Controllers;

use App\Support\DummyCafeData;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $categoryId = $request->integer('kategori');
        $menus = array_filter(
            DummyCafeData::menuItems(),
            fn (array $m) => $m['is_available'] && (! $categoryId || $m['category_id'] === $categoryId)
        );

        return view('menu.index', [
            'microsite' => DummyCafeData::microsite(),
            'categories' => DummyCafeData::categories(),
            'menus' => array_values($menus),
            'activeCategory' => $categoryId ?: null,
        ]);
    }

    public function show(int $id): View
    {
        $menu = DummyCafeData::findMenu($id);

        abort_if(! $menu || ! $menu['is_available'], 404);

        return view('menu.show', [
            'microsite' => DummyCafeData::microsite(),
            'menu' => $menu,
        ]);
    }
}
