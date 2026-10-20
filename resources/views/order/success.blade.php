@extends('layouts.app')

@section('title', 'Pesanan ' . $code)

@section('content')
    <div class="bg-white rounded-2xl border border-brand-100 p-8 text-center">
        <p class="text-5xl mb-3">✅</p>
        <h1 class="text-2xl font-bold">Pesanan Diterima!</h1>
        <p class="text-stone-600 mt-1">Kode pesanan: <span class="font-mono font-bold text-brand-700">{{ $code }}</span></p>
        <p class="text-sm text-stone-500 mt-1">Atas nama {{ $order['customer_name'] }} • Meja {{ $order['table_number'] }}</p>

        <div class="text-left mt-6 max-w-md mx-auto">
            @foreach ($order['items'] as $item)
                <div class="flex justify-between text-sm py-1.5 border-b border-stone-100">
                    <span>{{ $item['item_name'] }} × {{ $item['quantity'] }}</span>
                    <span class="font-medium">{{ rupiah($item['unit_price'] * $item['quantity']) }}</span>
                </div>
            @endforeach
            <p class="font-bold mt-2 text-right">Total {{ rupiah($order['total_price']) }}</p>
            <p class="text-sm mt-1">Status: <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full font-medium">{{ $order['status'] }}</span></p>
        </div>

        <div class="mt-6 flex justify-center gap-3">
            <a href="{{ route('menu.index') }}" class="bg-brand-700 text-white px-5 py-2 rounded-full font-semibold">Pesan Lagi</a>
            <a href="{{ route('order.track', ['kode' => $code]) }}" class="border border-brand-300 px-5 py-2 rounded-full font-semibold text-brand-700">Lacak</a>
        </div>
    </div>
@endsection
