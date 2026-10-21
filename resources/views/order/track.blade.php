@extends('layouts.app')

@section('title', 'Lacak Pesanan — ' . $microsite->name)

@section('content')
    <div class="max-w-lg mx-auto">
        <h1 class="font-serif text-3xl font-bold text-brand-900 mb-2">🔍 Lacak Pesanan</h1>
        <p class="text-stone-500 text-sm mb-10 reveal-up">Masukkan kode pesanan dari struk Anda</p>

        <form action="{{ route('order.track') }}" method="GET" class="glass rounded-2xl border border-brand-200 p-6 mb-10 reveal-up">
            <div class="flex gap-2">
                <input type="text" name="kode" value="{{ $code }}" placeholder="cth: KAFE-XXXX"
                       class="flex-1 border border-stone-300 rounded-xl px-4 py-3 input-luxury">
                <button class="btn-gold bg-gold-400 text-brand-900 font-bold px-6 py-3 rounded-xl hover:bg-gold-300 transition-all">
                    Cari
                </button>
            </div>
        </form>

        @if ($searched)
            @if ($order)
                <div class="glass rounded-2xl border border-brand-200 p-6 reveal-up" style="animation-delay: 0.1s;">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-mono text-xl font-bold text-brand-900">{{ $order->order_code }}</span>
                        <span class="bg-gold-100 text-gold-800 px-2 py-0.5 rounded-full text-xs font-medium">
                            {{ $order->status }}
                        </span>
                    </div>
                    <p class="text-stone-600 text-sm mb-6">{{ $order->customer_name }} • Meja {{ $order->table_number }}</p>

                    {{-- Timeline --}}
                    <div class="relative pl-8 mb-6">
                        <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-brand-200"></div>

                        @php
                            $statuses = ['pending' => 'Diterima', 'processing' => 'Diproses', 'ready' => 'Siap', 'completed' => 'Selesai'];
                            $statusOrder = ['pending', 'processing', 'ready', 'completed'];
                            $currentIndex = array_search($order->status, $statusOrder) ?? 0;
                        @endphp

                        @foreach ($statusOrder as $index => $statusKey)
                            @php $isActive = $index <= $currentIndex; @endphp
                            <div class="flex items-center mb-4 last:mb-0 relative z-10">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center
                                    {{ $isActive ? 'bg-gold-400 border-2 border-gold-400 text-white' : 'bg-brand-50 border border-brand-200 text-brand-400' }}
                                    shadow-sm transition-all">
                                    <span class="text-xs font-bold">{{ $index + 1 }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium {{ $isActive ? 'text-brand-900' : 'text-stone-400' }}">
                                        {{ $statuses[$statusKey] }}
                                    </p>
                                    <p class="text-xs {{ $isActive ? 'text-brand-600' : 'text-stone-300' }}">
                                        {{ $index === 0 ? 'Pesanan telah diterima' : ($index === count($statusOrder)-1 ? 'Selesai' : '') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Detail item --}}
                    <div class="space-y-3">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between text-sm border-b border-brand-50 pb-2">
                                <span class="text-stone-600">{{ $item->item_name }} × {{ $item->quantity }}</span>
                                <span class="font-medium text-brand-800">{{ rupiah($item->unit_price * $item->quantity) }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between mt-4 pt-4 border-t border-brand-100">
                            <span class="font-bold text-brand-900">Total</span>
                            <span class="font-serif text-lg font-bold text-brand-900">{{ rupiah($order->total_price) }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12 reveal-up">
                    <div class="text-4xl mb-4">🔍</div>
                    <h3 class="font-serif text-xl font-bold text-brand-900 mb-2">Pesanan tidak ditemukan</h3>
                    <p class="text-stone-500">Kode pesanan <span class="font-mono font-bold">{{ $code }}</span> tidak ditemukan dalam kami.</p>
                </div>
            @endif
        @else
            <div class="text-center py-12 reveal-up">
                <p class="text-stone-500 text-sm">Masukkan kode pesanan dari struk/halaman sukses.</p>
            </div>
        @endif
    </div>
@endsection
