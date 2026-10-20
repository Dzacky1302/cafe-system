<?php

namespace App\Http\Controllers;

use App\Support\DummyCafeData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index');
        }

        $total = collect($cart)->sum(fn (array $i) => $i['unit_price'] * $i['quantity']);

        return view('checkout.create', [
            'microsite' => DummyCafeData::microsite(),
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'table_number' => ['nullable', 'string', 'max:10'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Fase 1: simulasi pesanan (belum simpan ke DB).
        // Fase 2: ganti dengan Order::create + OrderItem::createMany transaksional.
        $total = collect($cart)->sum(fn (array $i) => $i['unit_price'] * $i['quantity']);
        $order = [
            'order_code' => 'KAFE-'.str_pad((string) random_int(1, 999), 3, '0', STR_PAD_LEFT),
            'customer_name' => $data['customer_name'],
            'table_number' => $data['table_number'] ?? '-',
            'notes' => $data['notes'] ?? '',
            'status' => 'baru',
            'total_price' => $total,
            'items' => array_values($cart),
        ];

        session()->forget('cart');
        session(['last_order' => $order]);

        return redirect()->route('order.success', ['code' => $order['order_code']]);
    }

    public function success(string $code): View
    {
        $order = session('last_order', DummyCafeData::sampleOrder());

        return view('order.success', [
            'microsite' => DummyCafeData::microsite(),
            'order' => $order,
            'code' => $code,
        ]);
    }

    public function track(Request $request): View
    {
        $code = trim((string) $request->query('kode', ''));
        $order = null;

        if ($code !== '') {
            // Fase 1: hanya contoh statis. Fase 2: Order::where('order_code', $code)->first().
            $sample = DummyCafeData::sampleOrder();
            $order = strcasecmp($sample['order_code'], $code) === 0 ? $sample : null;
        }

        return view('order.track', [
            'microsite' => DummyCafeData::microsite(),
            'code' => $code,
            'order' => $order,
            'searched' => $code !== '',
        ]);
    }
}
