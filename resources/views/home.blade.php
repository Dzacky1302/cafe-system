@extends('layouts.app')

@section('title', $microsite->name . ' — Nongkrong Asik')

@section('content')
    {{-- Hero --}}
    <section class="relative h-96 sm:h-[500px] rounded-3xl overflow-hidden mb-10 reveal-up">
        <div class="absolute inset-0 bg-gradient-to-b from-brand-900/90 via-brand-800/70 to-brand-900/95"></div>
        @if ($microsite->logo && admin_storage_url($microsite->logo))
            <img src="{{ admin_storage_url($microsite->logo) }}" class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
            <span class="inline-block py-1 px-4 rounded-full bg-gold-400/20 border border-gold-400/40 text-gold-300 text-xs font-semibold tracking-wider uppercase mb-6 animate-fade-in-up">
                ☕ Kopi Premium
            </span>
            <h1 class="font-serif text-4xl sm:text-6xl font-bold text-white mb-4 leading-tight animate-fade-in-up" style="animation-delay: 0.1s;">
                Selamat Datang di {{ $microsite->name }}
            </h1>
            <p class="text-brand-100 text-lg sm:text-xl mb-8 max-w-lg mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ $microsite->settings['tagline'] ?? 'Kopi terbaik disajikan dengan hangat dan penuh cinta' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center animate-fade-in-up" style="animation-delay: 0.3s;">
                <a href="{{ route('menu.index') }}" class="btn-gold bg-gold-400 text-white font-semibold px-8 py-3 rounded-full hover:bg-gold-300 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                    Lihat Menu →
                </a>
                <a href="{{ route('order.track') }}" class="bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold px-6 py-3 rounded-full hover:bg-white/20 transition-all">
                    Lacak Pesanan
                </a>
            </div>
        </div>
    </section>

    {{-- Promo --}}
    @if (count($promos))
        <section class="mb-12 reveal-up">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-serif text-2xl font-bold text-brand-900">🎉 Promo Spesial</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($promos as $promo)
                    <div class="glass p-6 rounded-2xl card-lift border border-brand-200">
                        <p class="font-serif font-bold text-xl text-brand-800 mb-2">{{ $promo->title }}</p>
                        <p class="text-stone-600 text-sm mb-4">{{ $promo->description }}</p>
                        <p class="text-xs text-brand-500 font-medium">Berlaku s.d. {{ $promo->end_date->isoFormat('D MMM Y') }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Info fitur --}}
    <section class="mb-12 grid md:grid-cols-3 gap-6">
        @foreach([
            ['icon' => '☕', 'title' => 'Kopi Premium', 'desc' => 'Bij kopi pilihan dari petani lokal'],
            ['icon' => '🥐', 'title' => 'Makanan Ringan', 'desc' => 'Pastry dan sandwich segar setiap hari'],
            ['icon' => '📶', 'title' => 'Wi-Fi Gratis', 'desc' => 'Nyaman untuk nongkrong maupun bekerja'],
        ] as $feat)
            <div class="glass p-6 rounded-2xl text-center card-lift reveal-up">
                <div class="text-4xl mb-3 float-slow">{{ $feat['icon'] }}</div>
                <h3 class="font-serif text-xl font-bold text-brand-900 mb-2">{{ $feat['title'] }}</h3>
                <p class="text-stone-600 text-sm">{{ $feat['desc'] }}</p>
            </div>
        @endforeach
    </section>

    {{-- Kategori --}}
    <section class="mb-12 reveal-up">
        <h2 class="font-serif text-2xl font-bold text-brand-900 mb-8 text-center">📂 Pilih Kategori</h2>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach ($categories as $cat)
                <a href="{{ route('menu.index', ['kategori' => $cat->id]) }}"
                   class="px-6 py-3 rounded-full text-sm font-medium transition-all {{ is_null($activeCategory) ? 'bg-brand-900 text-white shadow-lg' : 'bg-white border border-brand-200 text-stone-600 hover:bg-brand-100 hover:text-brand-700' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- Menu unggulan --}}
    <section class="mb-12 reveal-up">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-serif text-2xl font-bold text-brand-900">⭐ Menu Favorit</h2>
            <a href="{{ route('menu.index') }}" class="text-sm text-brand-500 hover:text-brand-800 transition-colors">Lihat semua →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($featuredMenus as $menu)
                <a href="{{ route('menu.show', $menu->id) }}" class="group card-lift reveal-up">
                    <div class="relative h-48 rounded-2xl overflow-hidden mb-4 border border-brand-100 bg-white group-hover:border-brand-300 transition-colors">
                        @if ($menu->imageUrl())
                            <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-brand-100 flex items-center justify-center text-5xl float-slow">🍽️</div>
                        @endif
                        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur text-brand-800 text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ rupiah($menu->price) }}
                        </span>
                    </div>
                    <p class="font-semibold text-stone-800 text-sm">{{ $menu->name }}</p>
                    <p class="text-xs text-stone-400 mt-1">{{ $menu->category?->name }}</p>
                    <p class="text-brand-700 font-bold text-sm mt-1.5">{{ rupiah($menu->price) }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Galeri --}}
    <section class="reveal-up">
        <h2 class="font-serif text-2xl font-bold text-brand-900 mb-8 text-center">📸 Galeri</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($galleries as $g)
                <div class="rounded-2xl overflow-hidden border border-brand-100 card-lift bg-white">
                    @if (admin_storage_url($g->image))
                        <img src="{{ admin_storage_url($g->image) }}" alt="{{ $g->caption }}" class="h-32 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="h-32 bg-brand-100 flex items-center justify-center text-3xl">🖼️</div>
                    @endif
                    <p class="text-xs p-3 text-stone-500 text-center">{{ $g->caption }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endsection
