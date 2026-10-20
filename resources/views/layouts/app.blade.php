<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#faf5ef', 100: '#f3e8d8', 200: '#e6cfae', 300: '#d7b183',
                            400: '#c78f5c', 500: '#b37642', 600: '#8B5E3C', 700: '#6f4a2f',
                            800: '#5a3c27', 900: '#4a3222',
                        },
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-brand-50 text-stone-800 min-h-screen flex flex-col">
    <header class="bg-brand-800 text-white sticky top-0 z-10 shadow">
        <nav class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-lg">☕ {{ $microsite->name }}</a>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
                <a href="{{ route('menu.index') }}" class="hover:underline">Menu</a>
                <a href="{{ route('order.track') }}" class="hover:underline">Lacak Pesanan</a>
                <a href="{{ route('cart.index') }}" class="bg-brand-500 hover:bg-brand-400 px-3 py-1.5 rounded font-semibold">
                    🛒 Keranjang ({{ count(session('cart', [])) }})
                </a>
            </div>
        </nav>
    </header>

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 py-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-brand-900 text-brand-100 text-sm mt-8">
        <div class="max-w-5xl mx-auto px-4 py-6 flex flex-col sm:flex-row justify-between gap-2">
            <div>
                <p class="font-semibold">{{ $microsite->name }}</p>
                <p>{{ $microsite->settings['address'] ?? '' }}</p>
            </div>
            <div class="sm:text-right">
                <p>🕗 {{ $microsite->settings['open_hours'] ?? '' }}</p>
                <p>📞 {{ $microsite->settings['phone'] ?? '' }}</p>
            </div>
        </div>
    </footer>
</body>
</html>
