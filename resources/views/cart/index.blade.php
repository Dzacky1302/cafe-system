@extends('layouts.app')

@section('title', 'Keranjang — ' . $microsite['name'])

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="font-serif text-3xl font-bold text-brand-900 mb-2">🛒 Keranjang Belanja</h1>
        <p class="text-stone-500 text-sm mb-10 reveal-up">Periksa pesanan Anda sebelum checkout</p>

        @if (empty($cart))
            <div class="text-center py-20 reveal-up">
                <div class="text-6xl mb-4">🛒</div>
                <h3 class="font-serif text-xl font-bold text-brand-900 mb-2">Keranjang masih kosong</h3>
                <p class="text-stone-500">Belum ada item di keranjang Anda.</p>
                <a href="{{ route('menu.index') }}" class="mt-6 inline-block btn-gold bg-gold-400 text-brand-900 font-semibold px-8 py-3 rounded-full hover:bg-gold-300 transition-all">
                    Pilih Menu →
                </a>
            </div>
        @else
            <div class="glass rounded-2xl border border-brand-200 overflow-hidden reveal-up">
                @foreach ($cart as $id => $item)
                    <div class="p-6 border-b border-brand-100 last:border-0 flex flex-col md:flex-row items-center justify-between gap-4 group hover:bg-brand-50/50 transition-colors">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-16 h-16 rounded-xl bg-brand-100 flex items-center justify-center text-xl flex-shrink-0">
                                🍽️
                            </div>
                            <div>
                                <p class="font-semibold text-stone-800 text-sm">{{ $item['item_name'] }}</p>
                                <p class="text-xs text-stone-500">{{ rupiah($item['unit_price']) }} × {{ $item['quantity'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="font-bold text-brand-900 text-sm">
                                {{ rupiah($item['unit_price'] * $item['quantity']) }}
                            </div>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <input type="number" name="qty" value="{{ $item['quantity'] }}" min="1" max="20"
                                       class="w-20 border border-stone-300 rounded-xl px-3 py-2 input-luxury text-center">
                                <button class="text-xs bg-stone-100 text-stone-600 px-3 py-1.5 rounded hover:bg-stone-200 transition-colors">
                                    Ubah
                                </button>
                            </form>
                            <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded hover:bg-red-100 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4 reveal-up" style="animation-delay: 0.2s;">
                <div>
                    <p class="text-stone-600 text-sm">Total Belanja</p>
                    <p class="font-serif text-2xl font-bold text-brand-900">{{ rupiah($total) }}</p>
                </div>
                <a href="{{ route('checkout.create') }}" class="btn-gold bg-gold-400 text-brand-900 font-bold py-3.5 rounded-xl px-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 hover:bg-gold-300 w-full sm:w-auto text-center">
                    Checkout Sekarang →
                </a>
            </div>
        @endif
    </div>
@endsection
