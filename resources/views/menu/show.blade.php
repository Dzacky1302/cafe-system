@extends('layouts.app')

@section('title', $menu->name . ' — ' . $microsite->name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 text-brand-500 hover:text-brand-800 text-sm font-medium mb-6 reveal-up transition-colors">
            ← Kembali ke menu
        </a>

        <div class="grid md:grid-cols-2 gap-8 reveal-up">
            <div class="relative rounded-3xl overflow-hidden border border-brand-100 shadow-xl">
                @if ($menu->imageUrl())
                    <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}" class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-brand-100 flex items-center justify-center text-6xl">🍽️</div>
                @endif
                <span class="absolute top-4 left-4 bg-white/90 backdrop-blur text-brand-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                    {{ $menu->category?->name }}
                </span>
            </div>

            <div class="flex flex-col">
                <p class="text-xs uppercase tracking-wider text-brand-500 font-semibold mb-2">{{ $menu->category?->name }}</p>
                <h1 class="font-serif text-4xl font-bold text-brand-900 mb-4 leading-tight">{{ $menu->name }}</h1>
                <p class="text-stone-600 text-lg leading-relaxed mb-6">{{ $menu->description }}</p>

                <div class="bg-brand-50/50 border border-brand-100 rounded-2xl p-6 mb-6">
                    <div class="flex items-baseline gap-2 mb-4">
                        <span class="font-serif text-3xl font-bold text-brand-900">{{ rupiah($menu->price) }}</span>
                        <span class="text-stone-500 text-sm">per porsi</span>
                    </div>
                    <p class="text-sm text-stone-600">Dibarui segar setiap hari dengan biji kopi terbaik.</p>
                </div>

                <form action="{{ route('cart.store', $menu->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-stone-600 uppercase mb-2">Quantity</label>
                        <div class="relative">
                            <input type="number" name="qty" value="1" min="1" max="20"
                                   class="w-full border border-stone-300 rounded-xl px-4 py-3 input-luxury text-center">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-stone-400 text-sm">pcs</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-gold bg-gold-400 text-brand-900 font-bold py-3.5 rounded-xl px-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 hover:bg-gold-300 flex items-center justify-center gap-2">
                        + Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
