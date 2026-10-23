@extends('layouts.app')

@section('title', 'Menu — ' . $microsite->name)

@section('content')
    {{-- ============ HEADER ============ --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 reveal-up">
        <div>
            <p class="text-[11px] uppercase tracking-[0.28em] mb-2" style="color: var(--gold-400);">Katalog</p>
            <h1 class="font-serif text-4xl sm:text-5xl font-bold mb-2" style="color: var(--gold-100);"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--gold-100)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4h10v4H7zM7 10h10v4H7zM7 16h10v4H7z"/></svg> Daftar Menu</h1>
            <p class="text-sm" style="color: rgba(248,217,125,0.55);">Pilih kopi dan makanan favorit Anda</p>
        </div>
        <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 border border-stone-500/20 bg-white/5 hover:bg-white/10 hover:border-stone-500/30 group">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
            <span class="text-brand-900 font-semibold tracking-tight">Kembali ke Beranda</span>
        </a>
    </div>

    {{-- ============ CATEGORY FILTERS ============ --}}
    <div class="flex flex-wrap justify-center gap-3 mb-12 reveal-up" style="transition-delay: 0.1s;">
        @php $isAll = is_null($activeCategory); @endphp
        <a href="{{ route('menu.index') }}" class="px-6 py-3 rounded-full text-sm font-medium transition-all {{ $isAll ? 'btn-gold' : 'btn-gold-outline' }}">
            Semua
        </a>
        @foreach ($categories as $cat)
            @php $isActive = (!is_null($activeCategory) && (int) $activeCategory === (int) $cat->id); @endphp
            <a href="{{ route('menu.index', ['kategori' => $cat->id]) }}" class="px-6 py-3 rounded-full text-sm font-medium transition-all {{ $isActive ? 'btn-gold' : 'btn-gold-outline' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    {{-- ============ MENU GRID ============ --}}
    @if ($menus->isEmpty())
        <div class="text-center py-24 reveal-up">
            <div class="text-6xl mb-5"><svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--gold-400)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4h10v4H7zM7 10h10v4H7zM7 16h10v4H7z"/></svg></div>
            <h3 class="font-serif text-2xl font-bold mb-2" style="color: var(--gold-100);">Belum ada menu</h3>
            <p class="text-sm" style="color: rgba(248,217,125,0.5);">Kategori ini masih kosong. Coba kategori lainnya.</p>
        </div>
    @else
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 stagger">
            @foreach ($menus as $item)
                <a href="{{ route('menu.show', $item->id) }}" class="card-gold group block overflow-hidden">
                    <div class="relative h-48 overflow-hidden">
                        @if ($item->imageUrl())
                            <img src="{{ $item->imageUrl() }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl" style="background: rgba(212,175,55,0.07);">️</div>
                        @endif
                        <div class="absolute inset-0" style="background: linear-gradient(180deg, transparent 45%, rgba(11,7,5,0.88) 100%);"></div>
                        <span class="absolute top-3 right-3 badge-gold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ rupiah($item->price) }}
                        </span>
                    </div>

                    <div class="p-5">
                        <p class="font-semibold text-sm mb-1" style="color: var(--gold-100);">{{ $item->name }}</p>
                        <p class="text-xs mb-3" style="color: rgba(248,217,125,0.45);">{{ $item->category?->name }}</p>
                        <p class="font-serif text-lg font-bold" style="color: var(--gold-300);">{{ rupiah($item->price) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection