@extends('layouts.app')

@section('title', 'Lacak Pesanan — ' . $microsite->name)

@section('content')
    <h1 class="text-2xl font-bold mb-4">🔍 Lacak Pesanan</h1>

    <form action="{{ route('order.track') }}" method="GET" class="flex gap-2 mb-5">
        <input type="text" name="kode" value="{{ $code }}" placeholder="cth: KAFE-XXXX"
               class="flex-1 border border-stone-300 rounded-full px-4 py-2">
        <button class="bg-brand-700 text-white px-5 py-2 rounded-full font-semibold">Cari</button>
    </form>

    @if ($searched)
        @if ($order)
            <div class="bg-white rounded-xl border border-brand-100 p-5">
                <p class="font-mono font-bold text-brand-700">{{ $order->order_code }}</p>
                <p class="text-sm text-stone-600 mt-1">{{ $order->customer_name }} • Meja {{ $order->table_number }}</p>
                <p class="text-sm mt-2">Status:
                    <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full font-medium">{{ $order->status }}</span>
                </p>
                <div class="mt-3">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between text-sm py-1 border-b border-stone-100">
                            <span>{{ $item->item_name }} × {{ $item->quantity }}</span>
                            <span>{{ rupiah($item->unit_price * $item->quantity) }}</span>
                        </div>
                    @endforeach
                    <p class="font-bold mt-2 text-right">{{ rupiah($order->total_price) }}</p>
                </div>
            </div>
        @else
            <p class="text-stone-500">Pesanan dengan kode <span class="font-mono font-bold">{{ $code }}</span> tidak ditemukan.</p>
        @endif
    @else
        <p class="text-stone-500 text-sm">Masukkan kode pesanan dari struk/halaman sukses.</p>
    @endif
@endsection
