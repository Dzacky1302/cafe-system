@extends('layouts.app')

@section('title', 'Lacak Pesanan — ' . $microsite->name)

@section('content')
    <div class="max-w-2xl mx-auto">
        {{-- ============ HEADER ============ --}}
        <div class="text-center mb-10 reveal-up">
            <p class="text-[11px] uppercase tracking-[0.28em] mb-2 text-gold-600 dark:text-gold-400">Order Tracking</p>
            <h1 class="font-serif text-4xl sm:text-5xl font-bold mb-3 text-gold-700 dark:text-gold-100"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--gold-100)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><span class="ml-2">Lacak Pesanan</span></h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan kode pesanan dari struk Anda</p>
            <div class="gold-rule mt-5 max-w-xs mx-auto"></div>
        </div>

        {{-- ============ SEARCH FORM ============ --}}
        <form action="{{ route('order.track') }}" method="GET" class="glass rounded-2xl p-6 mb-10 reveal-up" style="transition-delay: 0.1s;">
            <label for="kode" class="form-label">Kode Pesanan</label>
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="kode" id="kode" value="{{ $code }}" placeholder="cth: KAFE-XXXX"
                       class="flex-1 input-luxury font-mono tracking-wider" autocomplete="off">
                <button class="btn-gold px-7 py-3 shrink-0">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    Cari
                </button>
            </div>
        </form>

        @if ($searched)
            @if ($order)
                {{-- ============ ORDER CARD ============ --}}
                <div class="glass rounded-2xl p-6 sm:p-7 mb-8 reveal-up" style="transition-delay: 0.15s;">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
                        <span class="font-mono text-xl font-bold tracking-wider text-gold-700 dark:text-gold-100">{{ $order->order_code }}</span>
                        @php
                            // Status yang benar-benar tersimpan di database (orders.status).
                            $statusMap = [
                                'baru'       => ['label' => 'Menunggu',     'class' => 'badge-status-pending'],
                                'diproses'   => ['label' => 'Diproses',     'class' => 'badge-status-preparing'],
                                'siap'       => ['label' => 'Siap Diantar', 'class' => 'badge-status-ready'],
                                'selesai'    => ['label' => 'Selesai',      'class' => 'badge-status-done'],
                                'dibatalkan' => ['label' => 'Dibatalkan',   'class' => 'badge-status-cancel'],
                            ];
                            $current = $statusMap[$order->status] ?? ['label' => ucfirst((string) $order->status), 'class' => ''];
                        @endphp
                        <span class="badge-status {{ $current['class'] }}">
                            <span class="dot"></span>{{ $current['label'] }}
                        </span>
                    </div>
                    <p class="text-sm mb-7 text-gray-500 dark:text-gray-400">
                        {{ $order->customer_name }} <span class="text-gray-500 dark:text-gray-400">•</span> Meja {{ $order->table_number }}
                    </p>
                    {{-- ============ TIMELINE ============ --}}
                    @php
                        // Urutan status sesuai nilai yang tersimpan di database (orders.status).
                        $statuses = [
                            'baru'     => 'Diterima',
                            'diproses' => 'Diproses',
                            'siap'     => 'Siap Disajikan',
                            'selesai'  => 'Selesai',
                        ];
                        $statusOrder = array_keys($statuses);
                        $rawStatus = (string) ($order->status ?? 'baru');
                        $isCancelled = $rawStatus === 'dibatalkan';
                        $currentIndex = array_search($rawStatus, $statusOrder, true);
                        if ($currentIndex === false) {
                            $currentIndex = 0;
                        }
                        $subtitles = [
                            'Pesanan telah diterima oleh barista',
                            'Barista sedang menyeduh pesanan Anda',
                            'Pesanan siap diantar ke meja Anda',
                            'Pesanan telah selesai',
                        ];
                    @endphp

                    @if ($isCancelled)
                        {{-- ============ ORDER DIBATALKAN ============ --}}
                        <div class="track-cancel mb-8">
                            <div class="track-cancel-title mb-1">Pesanan Dibatalkan</div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Pesanan ini telah dibatalkan. Silakan hubungi barista jika Anda membutuhkan bantuan.
                            </p>
                        </div>
                    @endif

                    <div class="track-timeline {{ $isCancelled ? 'is-cancelled' : '' }} mb-8">
                        @foreach ($statusOrder as $index => $statusKey)
                            @php
                                $state = $isCancelled
                                    ? 'is-cancelled'
                                    : ($index < $currentIndex ? 'is-done' : ($index === $currentIndex ? 'is-current' : 'is-pending'));
                            @endphp
                            <div class="track-step {{ $state }}">
                                <span class="node">
                                    @if ($isCancelled)
                                        <span class="dot"></span>
                                    @elseif ($index < $currentIndex)
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#0b0705" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                    @elseif ($index === $currentIndex)
                                        <span class="dot"></span>
                                    @endif
                                </span>
                                <p class="font-medium text-sm" style="color: {{ (! $isCancelled && $index <= $currentIndex) ? 'var(--gold-100)' : 'rgba(248,217,125,0.35)' }};">
                                    {{ $statuses[$statusKey] }}
                                </p>
                                <p class="text-xs mt-0.5" style="color: {{ (! $isCancelled && $index <= $currentIndex) ? 'rgba(248,217,125,0.5)' : 'rgba(248,217,125,0.25)' }};">
                                    @if ($isCancelled)
                                        Tidak dilanjutkan
                                    @else
                                        {{ $index === $currentIndex ? 'Sedang berlangsung' : $subtitles[$index] }}
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                    {{-- ============ ITEMS ============ --}}
                    <div class="gold-rule mb-6"></div>

                    <div class="space-y-3">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between items-center text-sm pb-3" style="border-bottom: 1px solid rgba(212,175,55,0.08);">
                                <span class="text-gray-400 dark:text-gray-300">{{ $item->item_name }} <span class="text-gray-500 dark:text-gray-400">× {{ $item->quantity }}</span></span>
                                <span class="font-medium text-gold-500 dark:text-gold-200">{{ rupiah($item->unit_price * $item->quantity) }}</span>
                            </div>
                        @endforeach

                        <div class="flex justify-between items-center mt-5 pt-5" style="border-top: 1px solid var(--line-gold);">
                            <span class="font-bold text-gold-700 dark:text-gold-100">Total</span>
                            <span class="font-serif text-2xl font-bold fade-gold">{{ rupiah($order->total_price) }}</span>
                        </div>
                    </div>
                </div>
            @else
                {{-- ============ NOT FOUND ============ --}}
                <div class="text-center py-16 reveal-up">
                    <div class="text-5xl mb-5"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold-400)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg></div>
                    <h3 class="font-serif text-2xl font-bold mb-2 text-gold-700 dark:text-gold-100">Pesanan tidak ditemukan</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Kode pesanan <span class="font-mono font-bold text-gold-500 dark:text-gold-300">{{ $code }}</span> tidak ditemukan pada kami.
                    </p>
                </div>
            @endif
        @else
            {{-- ============ EMPTY STATE ============ --}}
            <div class="text-center py-16 reveal-up">
                <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan kode pesanan dari struk / halaman sukses.</p>
            </div>
        @endif
    </div>
@endsection