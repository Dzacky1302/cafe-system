<!-- ================================================================
     KAFE-SYSTEM - Microsite Online Ordering
     ================================================================ -->
<p align="center">
  <img src="https://cdn-icons-png.flaticon.com/512/2554/2554270.png" width="120" alt="Café Logo">
</p>

<h1 align="center">Café System</h1>

<p align="center">
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS"></a>
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP"></a>
  <a href="https://www.mysql.com"><img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL"></a>
  <a href="https://vitejs.dev"><img src="https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite" alt="Vite"></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge" alt="License"></a>
</p>

---

## 🎯 Overview

**Café System** adalah microsite pemesanan makanan & minuman berbasis web (Laravel 12). Aplikasi ini dirancang untuk kafe/rumah makan dengan antarmuka penjualan yang modern, responsif, dan mudah digunakan.

### Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| 🏠 **Halaman Utama** | Hero section, informasi kafe, kontak, tim |
| 🍽 **Menu Makanan** | Kategori lengkap, filter, deskripsi detail, gambar |
| 🛒 **Shopping Cart** | Tambah/hapus items, update qty, subtotal live |
| 💳 **Checkout** | Form konfirmasi + pembayaran (simulasi) |
| ✅ **Order Success** | Konfirmasi pesanan & detail invoice |
| 📍 **Track Pesanan** | Timeline: Baru → Diproses → Siap → Selesai |

### Tech Stack

- **Framework**: Laravel 12.x
- **UI**: Tailwind CSS 4.x + Vite
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0

---

## 📁 Struktur Proyek

```
café-system/
├── app/
│   ├── Http/Controllers/    # Controller (Home, Menu, Cart, Checkout)
│   ├── Models/              # Eloquent models (MenuItem, Menu, Order)
│   ├── Support/             # Helper functions
│   └── Providers/           # Service providers
├── config/
│   └── cafe.php             # Custom config
├── database/
│   ├── migrations/          # 12 migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── css/                 # Tailwind CSS
│   ├── views/               # Blade templates
│   │   ├── layouts/
│   │   ├── home.blade.php
│   │   ├── menu/            # Menu index & show
│   │   ├── cart/            # Cart index
│   │   ├── checkout/        # Checkout form
│   │   └── order/           # Success & track
│   └── js/                  # Vite assets
├── public/
├── routes/
│   └── web.php              # Web routes
├── tests/
├── .env
└── README.md
```


## 🚀 Instalasi

### Prasyarat
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8+

### Langkah Install

```bash
# 1. Clone repository
git clone https://github.com/Dzacky1302/cafe-system.git
cd kafe-system

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database (.env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kafe_system
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations
php artisan migrate

# 6. Seed database (opsional)
php artisan db:seed

# 7. Build assets
npm run build

# 8. Start development server
php artisan serve
```

### Commands

```bash
# Build assets
npm run dev
npm run build

# Run tests
php artisan test

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Serve
php artisan serve
```

---

## 🔗 Routes

| Method | URI | Controller | View |
|--------|-----|------------|------|
| GET | `/` | `HomeController@index` | `home.blade.php` |
| GET | `/menu` | `MenuController@index` | `menu/index.blade.php` |
| GET | `/menu/{category}` | `MenuController@index` | `menu/index.blade.php` |
| GET | `/menu/{slug}` | `MenuController@show` | `menu/show.blade.php` |
| GET | `/cart` | `CartController@index` | `cart/index.blade.php` |
| GET | `/checkout` | `CheckoutController@create` | `checkout/create.blade.php` |
| POST | `/checkout` | `CheckoutController@store` | Redirect |
| GET | `/success` | `CheckoutController@success` | `order/success.blade.php` |
| GET | `/track/{orderId}` | `HomeController@track` | `order/track.blade.php` |

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/MicrositeFlowTest.php

# Run with coverage
php artisan test --coverage
```

---

## 🐛 Troubleshooting

### Gagal saat `composer install`
```bash
php artisan key:generate
cp .env.example .env
```

### Asset tidak tampil
```bash
npm run build
```

---

## 🤝 Contributing

1. Fork it
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 License

The MIT License (MIT). Please see [LICENSE](LICENSE) file for more information.


