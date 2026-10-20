@extends('layouts.app')

@section('title', 'Checkout — ' . $microsite['name'])

@section('content')
    <h1 class="text-2xl font-bold mb-4">🧾 Checkout</h1>

    <div class="bg-white rounded-xl border border-brand-100 p-4 mb-4">
        <p class="font-semibold mb-2">Ringkasan ({{ count($cart) }} item)</p>
        @foreach ($cart as $item)
            <div class="flex justify-between text-sm py-1 border-b border-stone-100">
                <span>{{ $item['item_name'] }} × {{ $item['quantity'] }}</span>
                <span class="font-medium">{{ rupiah($item['unit_price'] * $item['quantity']) }}</span>
            </div>
        @endforeach
        <p class="font-bold mt-2 text-right">Total: <span class="text-brand-700">{{ rupiah($total) }}</span></p>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" class="bg-white rounded-xl border border-brand-100 p-4 space-y-3">
        @csrf
        <div>
            <label class="text-sm font-medium">Nama *</label>
            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                   class="w-full border border-stone-300 rounded px-3 py-2 mt-1" placeholder="Nama kamu">
            @error('customer_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-sm font-medium">No. Meja</label>
                <input type="text" name="table_number" value="{{ old('table_number') }}"
                       class="w-full border border-stone-300 rounded px-3 py-2 mt-1" placeholder="cth: 3">
            </div>
            <div>
                <label class="text-sm font-medium">No. HP</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                       class="w-full border border-stone-300 rounded px-3 py-2 mt-1" placeholder="08xx">
            </div>
        </div>
        <div>
            <label class="text-sm font-medium">Catatan</label>
            <textarea name="notes" rows="2" class="w-full border border-stone-300 rounded px-3 py-2 mt-1"
                      placeholder="cth: gula dipisah">{{ old('notes') }}</textarea>
        </div>
        <button class="w-full bg-brand-700 hover:bg-brand-600 text-white font-bold py-2.5 rounded-full">
            Buat Pesanan
        </button>
    </form>
@endsection
