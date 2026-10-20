@extends('layouts.app')

@section('title', $microsite['name'] . ' — Nongkrong Asik')

@section('content')
    {{-- Hero --}}
    <section class="bg-brand-700 text-white rounded-2xl p-8 mb-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-bold mb-2">Selamat Datang di {{ $microsite['name'] }} ☕</h1>
        <p class="text-brand-100 mb-1">{{ $microsite['settings']['address'] }}</p>
        <p class="text-brand-200 text-sm mb-5">Buka {{ $microsite['settings']['open_hours'] }}</p>
        <a href="{{ route('menu.index') }}" class="bg-white text-brand-800 font-bold px-6 py-2.5 rounded-full hover:bg-brand-100">
            Lihat Menu
        </a>
    </section>

    {{-- Promo --}}
    @if (count($promos))
        <section class="mb-8">
            <h2 class="text-xl font-bold mb-3">🎉 Promo Spesial</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                @foreach ($promos as $promo)
                    <div class="bg-amber-100 border border-amber-300 rounded-xl p-4">
                        <p class="font-bold text-amber-900">{{ $promo['title'] }}</p>
                        <p class="text-sm text-amber-800 mt-1">{{ $promo['description'] }}</p>
                        <p class="text-xs text-amber-600 mt-2">Berlaku s.d. {{ $promo['end_date'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Kategori --}}
    <section class="mb-8">
        <h2 class="text-xl font-bold mb-3">📂 Kategori</h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($categories as $cat)
                <a href="{{ route('menu.index', ['kategori' => $cat['id']]) }}"
                   class="bg-white border border-brand-200 px-4 py-2 rounded-full hover:bg-brand-100 text-sm font-medium">
                    {{ $cat['name'] }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- Menu unggulan --}}
    <section class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xl font-bold">⭐ Menu Favorit</h2>
            <a href="{{ route('menu.index') }}" class="text-sm text-brand-700 hover:underline">Lihat semua →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ($featuredMenus as $menu)
                <a href="{{ route('menu.show', $menu['id']) }}" class="bg-white rounded-xl shadow-sm border border-brand-100 overflow-hidden hover:shadow-md">
                    <div class="h-28 bg-brand-200 flex items-center justify-center text-4xl">🍽️</div>
                    <div class="p-3">
                        <p class="font-semibold text-sm">{{ $menu['name'] }}</p>
                        <p class="text-xs text-stone-500">{{ $menu['category'] }}</p>
                        <p class="text-brand-700 font-bold text-sm mt-1">{{ rupiah($menu['price']) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Galeri --}}
    <section>
        <h2 class="text-xl font-bold mb-3">📸 Galeri</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ($galleries as $g)
                <div class="bg-white rounded-xl border border-brand-100 overflow-hidden">
                    <div class="h-24 bg-stone-200 flex items-center justify-center text-3xl">🖼️</div>
                    <p class="text-xs p-2 text-stone-600">{{ $g['caption'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endsection
