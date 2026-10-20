<?php

namespace App\Http\Controllers;

use App\Support\DummyCafeData;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'microsite' => DummyCafeData::microsite(),
            'promos' => DummyCafeData::promos(),
            'categories' => DummyCafeData::categories(),
            'featuredMenus' => array_slice(
                array_filter(DummyCafeData::menuItems(), fn (array $m) => $m['is_available']),
                0,
                4
            ),
            'galleries' => DummyCafeData::galleries(),
        ]);
    }
}
