@extends('layouts.app')

@section('title', 'Menu — ' . $microsite->name)

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 reveal-up">
            <div>
                <h1 class="font-serif text-3xl font-bold text-brand-900 mb-1">🍽️ Daftar Menu</h1>
                <p class="text-stone-500 text-sm">Pilih kopi dan makanan favorit Anda</p>
            </div>
            <a href="{{ route('home') }}" class="text-brand-500 hover:text-brand-800 text-sm font-medium flex items-center gap-1 mt-4 md:mt-0 transition-colors">
                ← Kembali ke beranda
            </a>
        </div>

        <div class="flex flex-wrap justify-center gap-3 mb-10 reveal-up" style="animation-delay: 0.1s;">
        <a href="{{ route('menu.index') }}"
               class="px-6 py-3 rounded-full text-sm font-medium transition-all {{ is_null($activeCategory) ? 'bg-brand-900 text-white shadow-lg' : 'bg-white border border-brand-200 text-stone-600 hover:bg-brand-100 hover:text-brand-700' }}">
                Semua
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('menu.index', ['kategori' => $cat->id]) }}"
                   class="px-6 py-3 rounded-full text-sm font-medium transition-all {{ $activeCategory === $cat->id ? 'bg-brand-900 text-white shadow-lg' : 'bg-white border border-brand-200 text-stone-600 hover:bg-brand-100 hover:text-brand-700' }}">
                    {{ $cat->name }}
            </a>
        @endforeach
        </div>

        @if ($menus->isEmpty())
            <div class="text-center py-20 reveal-up">
                <div class="text-6xl mb-4">🍽️</div>
                <h3 class="font-serif text-xl font-bold text-brand-900 mb-2">Belum ada menu</h3>
                <p class="text-stone-500">Kategori ini masih kosong. Coba kategori lainnya.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($menus as $menu)
                    <a href="{{ route('menu.show', $menu->id) }}" class="group card-lift reveal-up">
                        <div class="relative h-52 rounded-2xl overflow-hidden mb-4 border border-brand-100 bg-white group-hover:border-brand-300 transition-colors">
                            @if ($menu->imageUrl())
                                <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-brand-100 flex items-center justify-center text-5xl float-slow">🍽️</div>
                            @endif
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur text-brand-800 text-xs font-bold px-2.5 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ rupiah($menu->price) }}
                            </span>
                        </div>
                        <p class="font-semibold text-stone-800 text-sm">{{ $menu->name }}</p>
                        <p class="text-xs text-stone-400 mt-1">{{ $menu->category?->name }}</p>
                        <p class="text-brand-700 font-bold text-sm mt-1.5">{{ rupiah($menu->price) }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
