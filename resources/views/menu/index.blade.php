@extends('layouts.app')

@section('title', 'Menu — ' . $microsite->name)

@section('content')
    <h1 class="text-2xl font-bold mb-4">🍽️ Daftar Menu</h1>

    <div class="flex flex-wrap gap-2 mb-5">
        <a href="{{ route('menu.index') }}"
           class="px-4 py-2 rounded-full text-sm font-medium {{ is_null($activeCategory) ? 'bg-brand-700 text-white' : 'bg-white border border-brand-200 hover:bg-brand-100' }}">
            Semua
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('menu.index', ['kategori' => $cat->id]) }}"
               class="px-4 py-2 rounded-full text-sm font-medium {{ $activeCategory === $cat->id ? 'bg-brand-700 text-white' : 'bg-white border border-brand-200 hover:bg-brand-100' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    @if ($menus->isEmpty())
        <p class="text-stone-500">Belum ada menu di kategori ini.</p>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @foreach ($menus as $menu)
                <a href="{{ route('menu.show', $menu->id) }}" class="bg-white rounded-xl shadow-sm border border-brand-100 overflow-hidden hover:shadow-md">
                    @if ($menu->imageUrl())
                        <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}" class="h-28 w-full object-cover">
                    @else
                        <div class="h-28 bg-brand-200 flex items-center justify-center text-4xl">🍽️</div>
                    @endif
                    <div class="p-3">
                        <p class="font-semibold text-sm">{{ $menu->name }}</p>
                        <p class="text-xs text-stone-500">{{ $menu->category?->name }}</p>
                        <p class="text-brand-700 font-bold text-sm mt-1">{{ rupiah($menu->price) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
