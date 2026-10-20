@extends('layouts.app')

@section('title', 'Keranjang — ' . $microsite['name'])

@section('content')
    <h1 class="text-2xl font-bold mb-4">🛒 Keranjang</h1>

    @if (empty($cart))
        <div class="bg-white rounded-xl border border-brand-100 p-8 text-center">
            <p class="text-stone-500 mb-4">Keranjang masih kosong.</p>
            <a href="{{ route('menu.index') }}" class="bg-brand-700 text-white px-5 py-2 rounded-full font-semibold">Pilih Menu</a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-brand-100 divide-y">
            @foreach ($cart as $id => $item)
                <div class="p-4 flex items-center justify-between gap-3">
                    <div>
                        <p class="font-semibold">{{ $item['item_name'] }}</p>
                        <p class="text-sm text-stone-500">{{ rupiah($item['unit_price']) }} × {{ $item['quantity'] }}</p>
                        <p class="font-bold text-brand-700 text-sm">{{ rupiah($item['unit_price'] * $item['quantity']) }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-1">
                            @csrf @method('PATCH')
                            <input type="number" name="qty" value="{{ $item['quantity'] }}" min="1" max="20"
                                   class="w-14 border border-stone-300 rounded px-1.5 py-1 text-sm">
                            <button class="text-xs bg-stone-200 px-2 py-1.5 rounded">Ubah</button>
                        </form>
                        <form action="{{ route('cart.destroy', $id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-100 text-red-700 px-2 py-1.5 rounded">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 flex items-center justify-between">
            <p class="font-bold text-lg">Total: <span class="text-brand-700">{{ rupiah($total) }}</span></p>
            <a href="{{ route('checkout.create') }}" class="bg-brand-700 hover:bg-brand-600 text-white font-semibold px-6 py-2.5 rounded-full">
                Checkout →
            </a>
        </div>
    @endif
@endsection
