<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Support\CurrentMicrosite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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

        // Ambil ulang menu dari DB: harga fresh + pastikan masih tersedia.
        $menus = MenuItem::where('is_available', true)
            ->whereIn('id', collect($cart)->pluck('menu_id'))
            ->get()
            ->keyBy('id');

        if ($menus->count() !== collect($cart)->pluck('menu_id')->unique()->count()) {
            session()->forget('cart');

            throw ValidationException::withMessages([
                'cart' => 'Sebagian menu di keranjang sudah tidak tersedia. Silakan pilih ulang.',
            ]);
        }

        $microsite = app(CurrentMicrosite::class)->get();

        $order = DB::transaction(function () use ($cart, $menus, $data, $microsite) {
            $total = 0;

            foreach ($cart as $item) {
                $total += $menus[$item['menu_id']]->price * $item['quantity'];
            }

            $order = Order::create([
                'microsite_id' => $microsite->id,
                'order_code' => $this->generateOrderCode(),
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'] ?? null,
                'table_number' => $data['table_number'] ?? null,
                'notes' => $data['notes'] ?? null,
                'status' => 'baru',
                'total_price' => $total,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'microsite_id' => $microsite->id,
                    'menu_item_id' => $item['menu_id'],
                    'item_name' => $menus[$item['menu_id']]->name,
                    'unit_price' => $menus[$item['menu_id']]->price,
                    'quantity' => $item['quantity'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');
        session(['last_order' => $order->only('order_code', 'customer_name', 'table_number', 'status', 'total_price')
            + ['items' => $order->items()->get()->only('item_name', 'unit_price', 'quantity')->all()]]);

        return redirect()->route('order.success', ['code' => $order->order_code]);
    }

    public function success(string $code): View|RedirectResponse
    {
        $order = session('last_order');

        if (! $order || $order['order_code'] !== $code) {
            return redirect()->route('order.track', ['kode' => $code]);
        }

        return view('order.success', [
            'order' => $order,
            'code' => $code,
        ]);
    }

    public function track(Request $request): View
    {
        $code = trim((string) $request->query('kode', ''));
        $order = null;

        if ($code !== '') {
            // Global scope MicrositeScope otomatis membatasi ke microsite kafe.
            $order = Order::where('order_code', $code)->with('items')->first();
        }

        return view('order.track', [
            'code' => $code,
            'order' => $order,
            'searched' => $code !== '',
        ]);
    }

    private function generateOrderCode(): string
    {
        do {
            $code = 'KAFE-'.strtoupper(Str::random(4));
        } while (Order::withoutGlobalScopes()->where('order_code', $code)->exists());

        return $code;
    }
}
