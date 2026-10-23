@extends('layouts.app')

@section('title', 'Pesanan ' . $code)

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <div class="flex flex-col items-center text-center reveal-up">
            <svg class="checkmark mb-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>

            <p class="text-[11px] uppercase tracking-[0.28em] mb-2" style="color: var(--gold-400);">Berhasil</p>
            <h1 class="font-serif text-4xl sm:text-5xl font-bold mb-3" style="color: var(--gold-100);">Pesanan Diterima!</h1>
            <p class="text-base mb-10" style="color: rgba(248,217,125,0.58);">
                Terima kasih telah memesan di {{ $microsite->name }}
            </p>

            {{-- ============ KODE PESANAN ============ --}}
            <div class="glass rounded-2xl p-7 w-full max-w-md mb-8">
                <p class="text-xs uppercase tracking-[0.22em] mb-3" style="color: rgba(248,217,125,0.45);">Kode Pesanan</p>
                <div class="font-mono text-3xl font-bold tracking-widest mb-4 fade-gold">{{ $code }}</div>
                <div class="gold-rule mb-4"></div>
                <p class="text-sm mb-1.5" style="color: rgba(248,217,125,0.65);">
                    Atas nama <span class="font-semibold" style="color: var(--gold-100);">{{ $order['customer_name'] }}</span>
                </p>
                <p class="text-sm" style="color: rgba(248,217,125,0.65);">Meja {{ $order['table_number'] }}</p>
            </div>

            {{-- ============ RINGKASAN ============ --}}
            <div class="text-left w-full max-w-md mb-9">
                <h3 class="font-serif text-xl font-bold mb-5" style="color: var(--gold-100);">Ringkasan Pesanan</h3>
                <div class="space-y-3">
                    @foreach ($order['items'] as $item)
                        <div class="flex justify-between items-center text-sm pb-3" style="border-bottom: 1px solid rgba(212,175,55,0.08);">
                            <span style="color: rgba(248,217,125,0.7);">{{ $item['item_name'] }} <span style="color: rgba(248,217,125,0.4);">× {{ $item['quantity'] }}</span></span>
                            <span class="font-medium" style="color: var(--gold-200);">{{ rupiah($item['unit_price'] * $item['quantity']) }}</span>
                        </div>
                    @endforeach

                    <div class="flex justify-between items-center mt-5 pt-5" style="border-top: 1px solid var(--line-gold);">
                        <span class="font-bold" style="color: var(--gold-100);">Total</span>
                        <span class="font-serif text-2xl font-bold fade-gold">{{ rupiah($order['total_price']) }}</span>
                    </div>
                </div>

                <p class="text-sm mt-5 flex items-center gap-2">
                    <span style="color: rgba(248,217,125,0.5);">Status:</span>
                    <span class="badge-status badge-status-pending">
                        <span class="dot"></span>{{ ucfirst($order['status']) }}
                    </span>
                </p>
            </div>

            {{-- ============ ACTIONS ============ --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center w-full">
                <a href="{{ route('menu.index') }}" class="btn-gold flex-1 text-center">Pesan Lagi</a>
                <a href="{{ route('order.track', ['kode' => $code]) }}" class="btn-gold-outline flex-1 text-center">Lacak Pesanan</a>
            </div>
        </div>
    </div>
@endsection