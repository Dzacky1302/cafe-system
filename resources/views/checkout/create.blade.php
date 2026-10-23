@extends('layouts.app')

@section('title', 'Checkout — ' . $microsite['name'])

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-10 reveal-up">
            <p class="text-[11px] uppercase tracking-[0.28em] mb-2" style="color: var(--gold-400);">Checkout</p>
            <h1 class="font-serif text-4xl sm:text-5xl font-bold mb-3" style="color: var(--gold-100);"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--gold-100)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="6 9 6 2 18 2"/><line x1="6" y1="9" x2="6" y2="2"/></svg><span class="ml-2">Checkout</span></h1>
            <p class="text-sm" style="color: rgba(248,217,125,0.55);">Isi detail pesanan Anda</p>
            <div class="gold-rule mt-5 max-w-xs mx-auto"></div>
        </div>

        {{-- ============ RINGKASAN ============ --}}
        <div class="glass rounded-2xl p-6 mb-8 reveal-up">
            <h3 class="font-serif text-xl font-bold mb-1" style="color: var(--gold-100);">Ringkasan Pesanan</h3>
            <p class="text-sm mb-5" style="color: rgba(248,217,125,0.5);">{{ count($cart) }} item</p>

            <div class="space-y-3">
                @foreach ($cart as $item)
                    <div class="flex justify-between items-center text-sm pb-3" style="border-bottom: 1px solid rgba(212,175,55,0.08);">
                        <span style="color: rgba(248,217,125,0.7);">{{ $item['item_name'] }} <span style="color: rgba(248,217,125,0.4);">× {{ $item['quantity'] }}</span></span>
                        <span class="font-medium" style="color: var(--gold-200);">{{ rupiah($item['unit_price'] * $item['quantity']) }}</span>
                    </div>
                @endforeach

                <div class="flex justify-between items-center mt-5 pt-5" style="border-top: 1px solid var(--line-gold);">
                    <span class="font-bold" style="color: var(--gold-100);">Total</span>
                    <span class="font-serif text-2xl font-bold fade-gold">{{ rupiah($total) }}</span>
                </div>
            </div>
        </div>

        {{-- ============ FORM ============ --}}
        <form action="{{ route('checkout.store') }}" method="POST" class="glass rounded-2xl p-6 space-y-6 reveal-up" style="transition-delay: 0.1s;">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="form-label" for="customer_name">Nama Lengkap <span style="color: var(--gold-400);">*</span></label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                           class="w-full input-luxury" placeholder="Nama Anda">
                    @error('customer_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="table_number">Nomor Meja</label>
                    <input type="text" name="table_number" id="table_number" value="{{ old('table_number') }}"
                           class="w-full input-luxury" placeholder="cth: 3">
                </div>

                <div class="sm:col-span-2">
                    <label class="form-label" for="customer_phone">Nomor HP</label>
                    <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}"
                           class="w-full input-luxury" placeholder="08123456789">
                </div>

                <div class="sm:col-span-2">
                    <label class="form-label" for="notes">Catatan Khusus</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full input-luxury resize-none"
                              placeholder="cth: gula dipisah, tidak pedas">{{ old('notes') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn-gold w-full py-4">
                Buat Pesanan
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
        </form>
    </div>
@endsection
