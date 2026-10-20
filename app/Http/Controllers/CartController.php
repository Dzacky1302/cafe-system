<?php

namespace App\Http\Controllers;

use App\Support\DummyCafeData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn (array $i) => $i['unit_price'] * $i['quantity']);

        return view('cart.index', [
            'microsite' => DummyCafeData::microsite(),
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request, int $id): RedirectResponse
    {
        $menu = DummyCafeData::findMenu($id);
        abort_if(! $menu || ! $menu['is_available'], 404);

        $qty = max(1, min(20, $request->integer('qty', 1)));
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min(20, $cart[$id]['quantity'] + $qty);
        } else {
            $cart[$id] = [
                'menu_id' => $menu['id'],
                'item_name' => $menu['name'],
                'unit_price' => $menu['price'],
                'quantity' => $qty,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', "{$menu['name']} masuk keranjang.");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $qty = max(1, min(20, $request->integer('qty', 1)));
            $cart[$id]['quantity'] = $qty;
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }
}
