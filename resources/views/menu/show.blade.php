@extends('layouts.app')

@section('title', $menu->name . ' — ' . $microsite->name)

@section('content')
    <div class="max-w-5xl mx-auto">
        <a href="{{ route('menu.index') }}" class="btn-ghost mb-6 reveal-left">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
            Kembali ke menu
        </a>

        <div class="grid md:grid-cols-2 gap-8">
            <div class="card-gold overflow-hidden reveal-left">
                <div class="relative h-72">
                    @if ($menu->imageUrl())
                        <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-6xl" style="background: rgba(212,175,55,0.07);">🍽️</div>
                    @endif
                    <div class="absolute inset-0" style="background: linear-gradient(180deg, transparent 50%, rgba(11,7,5,0.9) 100%);"></div>
                    <span class="absolute top-4 left-4 badge-gold">
                        {{ $menu->category?->name }}
                    </span>
                </div>
            </div>

            <div class="flex flex-col reveal-right">
                <p class="text-[11px] uppercase tracking-[0.28em] font-semibold mb-2" style="color: var(--gold-400);">{{ $menu->category?->name }}</p>
                <h1 class="font-serif text-4xl sm:text-5xl font-bold mb-4 leading-tight" style="color: var(--gold-100);">{{ $menu->name }}</h1>
                <p class="text-base leading-relaxed mb-6" style="color: rgba(248,217,125,0.62);">{{ $menu->description }}</p>

                <div class="glass rounded-2xl p-6 mb-6">
                    <div class="flex items-baseline gap-2 mb-3">
                        <span class="font-serif text-3xl font-bold fade-gold">{{ rupiah($menu->price) }}</span>
                        <span class="text-sm" style="color: rgba(248,217,125,0.45);">per porsi</span>
                    </div>
                    <p class="text-sm" style="color: rgba(248,217,125,0.5);">Dibarui segar setiap hari dengan biji kopi terbaik.</p>
                </div>

                <form action="{{ route('cart.store', $menu->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4 mt-auto">
                    @csrf
                    <div class="flex-1">
                        <label class="form-label" for="qty">Quantity</label>
                        <div class="relative">
                            <input type="number" name="qty" id="qty" value="1" min="1" max="20"
                                   class="w-full input-luxury text-center pr-14">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-sm" style="color: rgba(248,217,125,0.4);">pcs</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-gold px-8 py-3.5">
                        + Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
