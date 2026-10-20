@extends('layouts.app')

@section('title', $menu->name . ' — ' . $microsite->name)

@section('content')
    <a href="{{ route('menu.index') }}" class="text-sm text-brand-700 hover:underline">← Kembali ke menu</a>

    <div class="bg-white rounded-2xl border border-brand-100 mt-3 overflow-hidden">
        @if ($menu->imageUrl())
            <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}" class="h-56 w-full object-cover">
        @else
            <div class="h-56 bg-brand-200 flex items-center justify-center text-7xl">🍽️</div>
        @endif
        <div class="p-6">
            <p class="text-xs uppercase tracking-wide text-brand-600 font-semibold">{{ $menu->category?->name }}</p>
            <h1 class="text-2xl font-bold mt-1">{{ $menu->name }}</h1>
            <p class="text-stone-600 mt-2">{{ $menu->description }}</p>
            <p class="text-2xl font-bold text-brand-700 mt-3">{{ rupiah($menu->price) }}</p>

            <form action="{{ route('cart.store', $menu->id) }}" method="POST" class="mt-5 flex items-center gap-3">
                @csrf
                <label class="text-sm">Qty
                    <input type="number" name="qty" value="1" min="1" max="20"
                           class="w-16 border border-stone-300 rounded px-2 py-1.5 ml-1">
                </label>
                <button type="submit" class="bg-brand-700 hover:bg-brand-600 text-white font-semibold px-5 py-2 rounded-full">
                    + Keranjang
                </button>
            </form>
        </div>
    </div>
@endsection
