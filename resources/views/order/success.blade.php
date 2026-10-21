@extends('layouts.app')

@section('title', 'Pesanan ' . $code)

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <div class="flex flex-col items-center text-center reveal-up">
            <svg class="checkmark mb-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
            <h1 class="font-serif text-3xl font-bold text-brand-900 mb-2">Pesanan Diterima!</h1>
            <p class="text-stone-600 mb-8">Terima kasih telah memesan di {{ $microsite->name }}</p>

            <div class="glass rounded-2xl border border-brand-200 p-6 w-full max-w-md mb-8">
                <p class="text-xs font-medium text-stone-500 uppercase mb-3">Kode Pesanan</p>
                <div class="font-mono text-2xl font-bold text-brand-900 mb-4">{{ $code }}</p>
                <p class="text-sm text-stone-600 mb-2">Atas nama <span class="font-semibold">{{ $order['customer_name'] }}</span></p>
                <p class="text-sm text-stone-600">Meja {{ $order['table_number'] }}</p>
            </div>

            <div class="text-left w-full max-w-md mb-8">
                <h3 class="font-serif text-lg font-bold text-brand-900 mb-4">Ringkasan Pesanan</h3>
                <div class="space-y-3">
                    @foreach ($order['items'] as $item)
                        <div class="flex justify-between text-sm border-b border-brand-50 pb-2">
                            <span class="text-stone-600">{{ $item['item_name'] }} × {{ $item['quantity'] }}</span>
                            <span class="font-medium text-brand-800">{{ rupiah($item['unit_price'] * $item['quantity']) }}</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between mt-4 pt-4 border-t border-brand-100">
                        <span class="font-bold text-brand-900">Total</span>
                        <span class="font-serif text-lg font-bold text-brand-900">{{ rupiah($order['total_price']) }}</span>
                    </div>
                </div>
                <p class="text-sm mt-4">Status: <span class="bg-gold-100 text-gold-800 px-2 py-0.5 rounded-full font-medium">{{ $order['status'] }}</span></p>
            </div>

            <div class="flex gap-3 justify-center w-full">
                <a href="{{ route('menu.index') }}" class="flex-1 btn-gold bg-gold-400 text-brand-900 font-bold py-3 rounded-xl text-center shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                    Pesan Lagi
                </a>
                <a href="{{ route('order.track', ['kode' => $code]) }}" class="flex-1 bg-white border border-brand-200 text-brand-800 font-bold py-3 rounded-xl text-center hover:bg-brand-50 transition-colors">
                    Lacak Pesanan
                </a>
            </div>
        </div>
    </div>
@endsection
