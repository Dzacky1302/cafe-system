<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b0705">
    <title>@yield('title', config('app.name'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;0,800;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#1a110b', 100: '#221610', 200: '#2e1e15', 300: '#3d2e1a',
                            400: '#4a3d24', 500: '#8a6d1f', 600: '#b8860b', 700: '#d4af37',
                            800: '#f6c54f', 900: '#fbeeac',
                        },
                        gold: {
                            50: '#fdf6e3', 100: '#fbeeac', 200: '#f8d97d', 300: '#f6c54f',
                            400: '#d4af37', 500: '#b8860b', 600: '#8a6d1f', 700: '#5f4d15',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                    },
                },
            },
        };
    </script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="min-h-screen flex flex-col antialiased">
    {{-- Ambient background layers --}}
    <div class="star-field" id="starField" aria-hidden="true"></div>
    <div class="gold-glow" style="top:-18%; left:-12%;" aria-hidden="true"></div>
    <div class="gold-glow gold-glow-2" aria-hidden="true"></div>
    {{-- Navigation --}}
    <header class="nav-lux sticky top-0 z-50">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <a href="{{ route('home') }}" class="brand-mark flex items-center gap-2">
                <span>☕</span> {{ $microsite->name }}
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('menu.index') }}" class="nav-link {{ request()->routeIs('menu.*') ? 'active' : '' }}">Menu</a>
                <a href="{{ route('order.track') }}" class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}">Lacak Pesanan</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('cart.index') }}" class="btn-icon relative" aria-label="Keranjang">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/></svg>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if ($cartCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 flex items-center justify-center bg-gold-400 text-brand-900 text-[10px] font-bold rounded-full shadow-lg" style="animation: fxPulseDot 2s ease-in-out infinite;">{{ $cartCount }}</span>
                    @endif
                </a>

                <button type="button" id="mobileMenuBtn" class="btn-icon md:hidden" aria-label="Menu">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </nav>

        <div id="mobileMenu" class="md:hidden hidden border-t" style="border-color: var(--line-gold);">
            <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col gap-1">
                <a href="{{ route('home') }}" class="nav-link py-2">Beranda</a>
                <a href="{{ route('menu.index') }}" class="nav-link py-2">Menu</a>
                <a href="{{ route('order.track') }}" class="nav-link py-2">Lacak Pesanan</a>
            </div>
        </div>
    </header>

    {{-- Marquee --}}
    <div class="marquee-wrap">
        <div class="marquee-track">
            @php
                $marqueeItems = ['Kopi Premium', 'Single Origin', 'Roasted Fresh', 'Artisan Pastry', 'Specialty Brew', 'Slow Barista'];
            @endphp
            @for ($m = 0; $m < 2; $m++)
                @foreach ($marqueeItems as $item)
                    <span>{{ $item }}<i class="dot"></i></span>
                @endforeach
            @endfor
        </div>
    </div>
    {{-- Main content --}}
    <main class="flex-1 w-full max-w-6xl mx-auto px-4 sm:px-6 py-10 relative z-10">
        @if (session('success'))
            <div class="flash-gold mb-6">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flash-gold flash-gold-error mb-6">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="flash-gold flash-gold-error mb-6">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="site-footer mt-auto relative z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-12 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 pb-6" style="border-bottom: 1px solid rgba(212,175,55,0.12);">
                <div>
                    <h3 class="font-serif text-xl font-bold mb-3" style="color: var(--gold-100);">{{ $microsite->name }}</h3>
                    <p class="text-sm leading-relaxed" style="color: rgba(248,217,125,0.55);">{{ $microsite->settings['address'] ?? '' }}</p>
                </div>
                <div>
                    <h3 class="font-serif text-xl font-bold mb-3" style="color: var(--gold-100);">Tentang Kami</h3>
                    <p class="text-sm leading-relaxed" style="color: rgba(248,217,125,0.55);">Kopi premium yang disajikan dengan hangat dan penuh cinta untuk setiap momen nongkrong Anda.</p>
                </div>
                <div class="text-left md:text-right">
                    <h3 class="font-serif text-xl font-bold mb-3" style="color: var(--gold-100);">Kontak</h3>
                    <p class="text-sm mb-1" style="color: rgba(248,217,125,0.55);">🕗 {{ $microsite->settings['open_hours'] ?? '' }}</p>
                    <p class="text-sm mb-1" style="color: rgba(248,217,125,0.55);">📞 {{ $microsite->settings['phone'] ?? '' }}</p>
                    <div class="flex gap-3 mt-3">
                        <a href="#" class="btn-icon" aria-label="Facebook">📘</a>
                        <a href="#" class="btn-icon" aria-label="Instagram">📷</a>
                        <a href="#" class="btn-icon" aria-label="Twitter">🐦</a>
                    </div>
                </div>
            </div>
            <div class="text-center text-xs" style="color: rgba(248,217,125,0.4);">
                &copy; {{ date('Y') }} {{ $microsite->name }}. All rights reserved.
            </div>
        </div>
    </footer>
    <script>
        (function () {
            'use strict';

            // ---- Star field ----
            var starField = document.getElementById('starField');
            if (starField) {
                var starCount = window.innerWidth < 768 ? 40 : 90;
                var frag = document.createDocumentFragment();
                for (var i = 0; i < starCount; i++) {
                    var s = document.createElement('span');
                    s.className = 'star';
                    s.style.left = (Math.random() * 100).toFixed(2) + '%';
                    s.style.top = (Math.random() * 100).toFixed(2) + '%';
                    s.style.animationDelay = (Math.random() * 3.4).toFixed(2) + 's';
                    s.style.animationDuration = (2.4 + Math.random() * 3).toFixed(2) + 's';
                    frag.appendChild(s);
                }
                starField.appendChild(frag);
            }

            // ---- Scroll reveal ----
            var revealSelector = '.reveal-up, .reveal-left, .reveal-right, .reveal-scale';
            var revealObserver = null;
            if ('IntersectionObserver' in window) {
                revealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            revealObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });
            }

            function registerReveals() {
                var items = document.querySelectorAll(revealSelector);
                for (var j = 0; j < items.length; j++) {
                    if (revealObserver) {
                        revealObserver.observe(items[j]);
                    } else {
                        items[j].classList.add('visible');
                    }
                }
            }
            registerReveals();

            // ---- Nav scroll shadow ----
            var nav = document.querySelector('.nav-lux');
            function onScroll() {
                if (nav) {
                    nav.classList.toggle('scrolled', window.scrollY > 12);
                }
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();

            // ---- Mobile menu ----
            var menuBtn = document.getElementById('mobileMenuBtn');
            var mobileMenu = document.getElementById('mobileMenu');
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // ---- Hero particles ----
            var hero = document.querySelector('[data-particles]');
            if (hero) {
                var pCount = window.innerWidth < 768 ? 14 : 26;
                for (var p = 0; p < pCount; p++) {
                    var el = document.createElement('span');
                    el.className = 'particle';
                    var size = 3 + Math.random() * 7;
                    el.style.width = size + 'px';
                    el.style.height = size + 'px';
                    el.style.left = (Math.random() * 100).toFixed(2) + '%';
                    el.style.bottom = '-10px';
                    el.style.animationDuration = (11 + Math.random() * 14).toFixed(2) + 's';
                    el.style.animationDelay = (Math.random() * 12).toFixed(2) + 's';
                    hero.appendChild(el);
                }
            }
        })();
    </script>
</body>
</html>