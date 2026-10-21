@extends('layouts.app')

@section('title', 'Checkout — ' . $microsite['name'])

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="font-serif text-3xl font-bold text-brand-900 mb-2">🧾 Checkout</h1>
        <p class="text-stone-500 text-sm mb-10 reveal-up">Isi detail pesanan Anda</p>

        {{-- Ringkasan --}}
        <div class="glass rounded-2xl border border-brand-200 p-6 mb-8 reveal-up">
            <h3 class="font-serif text-lg font-bold text-brand-900 mb-4">Ringkasan Pesanan</h3>
            <p class="text-stone-600 text-sm mb-4">{{ count($cart) }} item</p>
            <div class="space-y-3">
                @foreach ($cart as $item)
                    <div class="flex justify-between text-sm border-b border-brand-50 pb-2">
                        <span class="text-stone-600">{{ $item['item_name'] }} × {{ $item['quantity'] }}</span>
                        <span class="font-medium text-brand-800">{{ rupiah($item['unit_price'] * $item['quantity']) }}</span>
                    </div>
                @endforeach
                <div class="flex justify-between mt-4 pt-4 border-t border-brand-100">
                    <span class="font-bold text-brand-900">Total</span>
                    <span class="font-serif text-lg font-bold text-brand-900">{{ rupiah($total) }}</span>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('checkout.store') }}" method="POST" class="glass rounded-2xl border border-brand-200 p-6 space-y-6 reveal-up" style="animation-delay: 0.1s;">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-medium text-stone-600 uppercase mb-2">Nama Lengkap <span class="text-brand-500">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                           class="w-full border border-stone-300 rounded-xl px-4 py-3 input-luxury" placeholder="Nama Anda">
                    @error('customer_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-stone-600 uppercase mb-2">Nomor Meja</label>
                    <input type="text" name="table_number" value="{{ old('table_number') }}"
                           class="w-full border border-stone-300 rounded-xl px-4 py-3 input-luxury" placeholder="cth: 3">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-stone-600 uppercase mb-2">Nomor HP</label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                           class="w-full border border-stone-300 rounded-xl px-4 py-3 input-luxury" placeholder="08123456789">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-stone-600 uppercase mb-2">Catatan Khusus</label>
                    <textarea name="notes" rows="3" class="w-full border border-stone-300 rounded-xl px-4 py-3 input-luxury"
                              placeholder="cth: gula dipisah, tidak pedas">{{ old('notes') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn-gold bg-gold-400 text-brand-900 font-bold py-3.5 rounded-xl px-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 hover:bg-gold-300 w-full flex items-center justify-center gap-2">
                Buat Pesanan →
            </button>
        </form>
    </div>
@endsection
