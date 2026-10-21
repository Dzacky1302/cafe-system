<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fbfaf5', 100: '#f3ede0', 200: '#e9dfc6', 300: '#d9c9a2',
                            400: '#c9b284', 500: '#b89a5e', 600: '#8d6e4a', 700: '#6f4e2e',
                            800: '#5a3d24', 900: '#4a321c',
                        },
                        gold: {
                            50: '#fdf6e3', 100: '#fbeeac', 200: '#f8d97d', 300: '#f6c54f',
                            400: '#d4af37', 500: '#b8860b', 600: '#8a6d1f', 700: '#5f4d15',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.7s ease-out forwards',
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'shimmer': 'shimmer 2.5s infinite',
                        'pulse-gold': 'pulseGold 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% 0' },
                            '100%': { backgroundPosition: '200% 0' },
                        },
                        pulseGold: {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(212, 175, 55, 0.7)' },
                            '50%': { boxShadow: '0 0 0 12px rgba(212, 175, 55, 0)' },
                        },
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-brand-50 text-stone-800 min-h-screen flex flex-col antialiased selection:bg-gold-200 selection:text-brand-900">
    <header class="bg-brand-50/80 backdrop-blur-md border-b border-brand-200 sticky top-0 z-50">
        <nav class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-serif text-xl font-bold text-brand-900 tracking-tight">
                ☕ {{ $microsite->name }}
            </a>
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-stone-600">
                <a href="{{ route('home') }}" class="hover:text-brand-700 transition-colors">Beranda</a>
                <a href="{{ route('menu.index') }}" class="hover:text-brand-700 transition-colors">Menu</a>
                <a href="{{ route('order.track') }}" class="hover:text-brand-700 transition-colors">Lacak Pesanan</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('cart.index') }}" class="relative p-2 hover:bg-brand-100 rounded-full transition-colors group">
                    🛒
                    <span class="absolute -top-1 -right-1 bg-gold-400 text-[10px] font-bold px-1.5 py-0.5 rounded-full animate-pulse-gold">
                        {{ count(session('cart', [])) }}
                    </span>
                </a>
            </div>
        </nav>
    </header>

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 shadow-sm animate-fade-in-up">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-brand-900 text-brand-100 mt-auto pt-12 pb-8">
        <div class="max-w-5xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 border-b border-brand-800 pb-6">
                <div>
                    <h3 class="font-serif text-lg font-bold text-white mb-3">{{ $microsite->name }}</h3>
                    <p class="text-brand-200 text-sm leading-relaxed">{{ $microsite->settings['address'] ?? '' }}</p>
                </div>
                <div>
                    <h3 class="font-serif text-lg font-bold text-white mb-3">Tentang Kami</h3>
                    <p class="text-brand-200 text-sm leading-relaxed">Kopi premium yang disajikan dengan hangat dan penuh cinta untuk setiap momen nongkrong Anda.</p>
                </div>
                <div class="text-right md:text-left">
                    <h3 class="font-serif text-lg font-bold text-white mb-3">Kontak</h3>
                    <p class="text-brand-200 text-sm mb-1">🕗 {{ $microsite->settings['open_hours'] ?? '' }}</p>
                    <p class="text-brand-200 text-sm mb-1">📞 {{ $microsite->settings['phone'] ?? '' }}</p>
                    <div class="flex gap-3 mt-3 justify-center md:justify-start">
                        <a href="#" class="text-brand-300 hover:text-white transition-colors">📘</a>
                        <a href="#" class="text-brand-300 hover:text-white transition-colors">📷</a>
                        <a href="#" class="text-brand-300 hover:text-white transition-colors">🐦</a>
                    </div>
                </div>
            </div>
            <div class="text-center text-brand-300 text-xs">
                &copy; {{ date('Y') }} {{ $microsite->name }}. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Scroll reveal animation
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
    </script>
</body>
</html>
