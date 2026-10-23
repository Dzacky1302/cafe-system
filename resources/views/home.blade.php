@extends('layouts.app')

@section('title', $microsite->name . ' — Nongkrong Asik')

@section('content')
    {{-- ============ HERO ============ --}}
    <section class="hero-section" data-particles>
        <div class="relative z-10 w-full max-w-4xl mx-auto">
            <span class="hero-eyebrow fade-in-up d1">
                <span><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold-300)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8h-1a4 4 0 0 0-4 4v6a4 4 0 0 0 4 4h1M4 18h16v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2"/></svg></span>
                Kopi Premium
            </span>

            <h1 class="hero-title text-4xl sm:text-6xl lg:text-7xl mt-7 mb-5 fade-gold">
                Selamat Datang<br class="hidden sm:block" />
                di {{ $microsite->name }}
            </h1>

            <p class="text-lg sm:text-xl mb-9 max-w-xl mx-auto fade-in-up d2 text-gray-500 dark:text-gray-400">
                {{ $microsite->settings['tagline'] ?? 'Kopi terbaik disajikan dengan hangat dan penuh cinta' }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in-up d3">
                <a href="{{ route('menu.index') }}" class="btn-gold">
                    Lihat Menu
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                <a href="{{ route('order.track') }}" class="btn-gold-outline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    Lacak Pesanan
                </a>
            </div>

            <div class="mt-14 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 fade-in-up d4">
                @foreach([
                    ['value' => $featuredMenus->count() . '+', 'label' => 'Menu Pilihan'],
                    ['value' => '100%', 'label' => 'Arabika Premium'],
                    ['value' => '24/7', 'label' => 'Open Night'],
                ] as $stat)
                    <div class="text-center">
                        <p class="font-serif text-2xl font-bold fade-gold">{{ $stat['value'] }}</p>
                        <p class="text-[11px] uppercase tracking-[0.18em] mt-1 text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="hero-scroll" aria-hidden="true">
            <span>Scroll</span>
            <span class="line"></span>
        </div>
    </section>

    {{-- ============ PROMO ============ --}}
    @if (count($promos))
        <section class="mb-16 reveal-up">
            <div class="text-center mb-8">
                <p class="text-[11px] uppercase tracking-[0.28em] mb-2 text-gold-600 dark:text-gold-400">Promo Spesial</p>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gold-700 dark:text-gold-100"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--gold-100)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l1.9 4.8L18.5 9.5H11v6h2.5l-4.6 4.7L7.5 18.5H6v-6H3.5l4.6-4.7L12 3z"/></svg><span class="ml-2">Penawaran Terbatas</span></h2>
                <div class="gold-rule mt-5 max-w-xs mx-auto"></div>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger">
                @foreach ($promos as $promo)
                    <div class="card-gold p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-2xl">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--gold-300)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M12 16h4"/><path d="M8 12h2"/><path d="M8 16h2"/></svg>
                            </span>
                            <span class="badge-gold">Diskon Spesial</span>
                        </div>
                        <h3 class="font-serif text-xl font-bold mb-2 text-gold-700 dark:text-gold-100">{{ $promo->title }}</h3>
                        <p class="text-sm mb-4 text-gray-500 dark:text-gray-400">{{ $promo->description }}</p>
                        <p class="text-xs font-medium text-gold-600 dark:text-gold-400">Berlaku s.d. {{ $promo->end_date->isoFormat('D MMM Y') }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    {{-- ============ FEATURES ============ --}}
    <section class="mb-16">
        <div class="grid md:grid-cols-3 gap-6 stagger">
            @foreach([
                ['icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--gold-300)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8h-1a4 4 0 0 0-4 4v6a4 4 0 0 0 4 4h1M4 18h16v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2"/></svg>', 'title' => 'Kopi Premium', 'desc' => 'Biji kopi pilihan dari petani lokal, di-roast dengan presisi tinggi.'],
                ['icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--gold-300)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/><path d="M4 19h16"/></svg>', 'title' => 'Makanan Ringan', 'desc' => 'Pastry dan sandwich segar yang diolah setiap hari di dapur kami.'],
                ['icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--gold-300)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 5h14v14H5zM5 5l14 14M14 14h6v6H14z"/><circle cx="12" cy="12" r="2"/></svg>', 'title' => 'Wi-Fi Gratis', 'desc' => 'Nyaman untuk nongkrong, bekerja, atau nongkrong panjang.'],
            ] as $feat)
                <div class="card-gold p-8 text-center reveal-up">
                    <div class="text-4xl mb-4">{!! $feat['icon'] !!}</div>
                    <h3 class="font-serif text-xl font-bold mb-2 text-gold-700 dark:text-gold-100">{{ $feat['title'] }}</h3>
                    <p class="text-sm leading-relaxed text-gray-500 dark:text-gray-400">{{ $feat['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ CATEGORIES ============ --}}
    <section class="mb-16 reveal-up">
        <div class="text-center mb-8">
            <p class="text-[11px] uppercase tracking-[0.28em] mb-2 text-gold-600 dark:text-gold-400">Kategori</p>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gold-700 dark:text-gold-100">Pilih Kategori</h2>
            <div class="gold-rule mt-5 max-w-xs mx-auto"></div>
        </div>

        <div class="flex flex-wrap justify-center gap-3">
            @foreach ($categories as $cat)
                @php $isActive = (!is_null($activeCategory) && (int) $activeCategory === (int) $cat->id); @endphp
                <a href="{{ route('menu.index', ['kategori' => $cat->id]) }}"
                   class="px-6 py-3 rounded-full text-sm font-medium transition-all {{ $isActive ? 'btn-gold' : 'btn-gold-outline' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- ============ FEATURED MENUS ============ --}}
    <section class="mb-16 reveal-up">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <p class="text-[11px] uppercase tracking-[0.28em] mb-2 text-gold-600 dark:text-gold-400">Rekomendasi</p>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gold-700 dark:text-gold-100"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--gold-100)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15 9 22 9.5 17 14 18.5 21 12 16.5 5.5 21 7 9.5 13 9.5 12 2"/></svg><span class="ml-2">Menu Favorit</span></h2>
            </div>
            <a href="{{ route('menu.index') }}" class="btn-ghost">
                Lihat semua
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 stagger">
            @foreach ($featuredMenus as $item)
                <a href="{{ route('menu.show', $item->id) }}" class="card-gold group block overflow-hidden">
                    <div class="relative h-44 overflow-hidden">
                        @if ($item->imageUrl())
                            <img src="{{ $item->imageUrl() }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl bg-gold-50 dark:bg-gray-900/20">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold-300)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4h10v4H7zM7 10h10v4H7zM7 16h10v4H7z"/></svg>
                        </div>
                        @endif
                        <div class="absolute inset-0" style="background: linear-gradient(180deg, transparent 45%, rgba(11,7,5,0.88) 100%);"></div>
                        <span class="absolute top-3 right-3 badge-gold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ rupiah($item->price) }}
                        </span>
                    </div>

                    <div class="p-5">
                        <p class="font-semibold text-sm mb-1 text-gold-700 dark:text-gold-100">{{ $item->name }}</p>
                        <p class="text-xs mb-3 text-gray-500 dark:text-gray-400">{{ $item->category?->name }}</p>
                        <p class="font-serif text-lg font-bold text-gold-500 dark:text-gold-300">{{ rupiah($item->price) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ============ GALLERY ============ --}}
    @if (count($galleries))
        <section class="reveal-up">
            <div class="text-center mb-8">
                <p class="text-[11px] uppercase tracking-[0.28em] mb-2 text-gold-600 dark:text-gold-400">Galeri</p>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gold-700 dark:text-gold-100"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--gold-100)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M3 16l4 4 9-9"/></svg><span class="ml-2">Suasana Kami</span></h2>
                <div class="gold-rule mt-5 max-w-xs mx-auto"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 stagger">
                @foreach ($galleries as $g)
                    <figure class="card-gold overflow-hidden group">
                        @if (admin_storage_url($g->image))
                            <img src="{{ admin_storage_url($g->image) }}" alt="{{ $g->caption }}" class="h-36 w-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="h-36 flex items-center justify-center text-3xl bg-gold-50 dark:bg-gray-900/20">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold-300)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M3 16l4 4 9-9"/></svg>
                        </div>
                        @endif
                        <figcaption class="p-3 text-xs text-center text-gray-500 dark:text-gray-400">{{ $g->caption }}</figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @endif
@endsection