@extends('layouts.app')

@section('title', 'Keranjang — ' . $microsite['name'])

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10 reveal-up">
            <p class="text-[11px] uppercase tracking-[0.28em] mb-2" style="color: var(--gold-400);">Shopping Cart</p>
            <h1 class="font-serif text-4xl sm:text-5xl font-bold mb-3" style="color: var(--gold-100);"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--gold-100)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg><span class="ml-2">Keranjang Belanja</span></h1>
            <p class="text-sm" style="color: rgba(248,217,125,0.55);">Periksa pesanan Anda sebelum checkout</p>
            <div class="gold-rule mt-5 max-w-xs mx-auto"></div>
        </div>

        @if (empty($cart))
            <div class="text-center py-24 reveal-up">
                <div class="text-6xl mb-5"><svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--gold-400)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg></div>
                <h3 class="font-serif text-2xl font-bold mb-2" style="color: var(--gold-100);">Keranjang masih kosong</h3>
                <p class="text-sm mb-7" style="color: rgba(248,217,125,0.5);">Belum ada item di keranjang Anda.</p>
                <a href="{{ route('menu.index') }}" class="btn-gold px-8 py-3.5">
                    Pilih Menu
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        @else
            <div class="glass rounded-2xl overflow-hidden reveal-up">
                @foreach ($cart as $id => $item)
                    <div class="p-5 sm:p-6 flex flex-col md:flex-row items-center justify-between gap-4 cart-row">
                        <div class="flex items-center gap-4 min-w-0 w-full md:w-auto">
                            <div class="w-16 h-16 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                                 style="background: rgba(212,175,55,0.08); border: 1px solid var(--line-gold);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold-300)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4h10v4H7zM7 10h10v4H7zM7 16h10v4H7z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-sm truncate" style="color: var(--gold-100);">{{ $item['item_name'] }}</p>
                                <p class="text-xs mt-1" style="color: rgba(248,217,125,0.5);">{{ rupiah($item['unit_price']) }} × {{ $item['quantity'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                            <span class="font-serif text-lg font-bold" style="color: var(--gold-300);">
                                {{ rupiah($item['unit_price'] * $item['quantity']) }}
                            </span>

                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <input type="number" name="qty" value="{{ $item['quantity'] }}" min="1" max="20"
                                       class="w-16 input-luxury text-center py-2">
                                <button class="btn-icon text-[11px] font-semibold" type="submit">Ubah</button>
                            </form>

                            <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn-icon btn-icon-danger text-[11px] font-semibold" type="submit" aria-label="Hapus item">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col sm:flex-row sm:items-end justify-between gap-5 reveal-up" style="transition-delay: 0.15s;">
                <div class="glass rounded-2xl px-6 py-4 flex-1">
                    <p class="text-xs uppercase tracking-[0.2em] mb-1" style="color: rgba(248,217,125,0.45);">Total Belanja</p>
                    <p class="font-serif text-3xl font-bold fade-gold">{{ rupiah($total) }}</p>
                </div>
                <a href="{{ route('checkout.create') }}" class="btn-gold px-8 py-3.5 sm:w-auto w-full text-center">
                    Checkout Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        @endif
    </div>
@endsection
