<?php

namespace App\Support;

/**
 * Data dummy Microsite Kafe (Fase 1).
 *
 * Struktur field dicerminkan plek dengan skema tabel di repo admin-panel
 * (microsites, categories, menu_items, galleries, promos, orders)
 * agar transisi ke database lokal (Fase 2) hanya mengganti sumber data.
 */
class DummyCafeData
{
    public static function microsite(): array
    {
        return [
            'name' => 'Kafe Colab',
            'slug' => 'kafe',
            'is_active' => true,
            'settings' => [
                'color' => '#8B5E3C',
                'open_hours' => '08.00 - 22.00',
                'address' => 'Jl. Kolaborasi No. 9, Purwokerto',
                'phone' => '0812-3456-7890',
            ],
        ];
    }

    public static function categories(): array
    {
        return [
            ['id' => 1, 'name' => 'Minuman', 'sort_order' => 1],
            ['id' => 2, 'name' => 'Camilan', 'sort_order' => 2],
            ['id' => 3, 'name' => 'Makanan Berat', 'sort_order' => 3],
        ];
    }

    public static function menuItems(): array
    {
        return [
            [
                'id' => 1,
                'category_id' => 1,
                'category' => 'Minuman',
                'name' => 'Kopi Susu',
                'description' => 'Espresso double shot dengan susu segar dan gula aren.',
                'price' => 18000,
                'image' => null,
                'is_available' => true,
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'category' => 'Minuman',
                'name' => 'Matcha Latte',
                'description' => 'Bubuk matcha premium dengan susu creamy.',
                'price' => 20000,
                'image' => null,
                'is_available' => true,
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'category' => 'Camilan',
                'name' => 'Kentang Goreng',
                'description' => 'Kentang renyah dengan taburan garam dan saus pendamping.',
                'price' => 15000,
                'image' => null,
                'is_available' => true,
            ],
            [
                'id' => 4,
                'category_id' => 2,
                'category' => 'Camilan',
                'name' => 'Pisang Goreng Cokelat',
                'description' => 'Pisang raja goreng dengan lelehan cokelat dan keju.',
                'price' => 14000,
                'image' => null,
                'is_available' => true,
            ],
            [
                'id' => 5,
                'category_id' => 3,
                'category' => 'Makanan Berat',
                'name' => 'Nasi Goreng Colab',
                'description' => 'Nasi goreng spesial dengan telur, ayam suwir, dan kerupuk.',
                'price' => 25000,
                'image' => null,
                'is_available' => true,
            ],
            [
                'id' => 6,
                'category_id' => 3,
                'category' => 'Makanan Berat',
                'name' => 'Mie Goreng Jawa',
                'description' => 'Mie goreng khas Jawa dengan sayuran dan ayam.',
                'price' => 22000,
                'image' => null,
                'is_available' => false,
            ],
        ];
    }

    public static function promos(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Happy Hour 15.00 - 17.00',
                'description' => 'Diskon 20% untuk semua varian kopi setiap hari pukul 15.00 - 17.00.',
                'start_date' => '2026-10-01',
                'end_date' => '2026-12-31',
            ],
            [
                'id' => 2,
                'title' => 'Paket Nongkrong Berdua',
                'description' => '2 kopi susu + 1 kentang goreng hanya Rp45.000.',
                'start_date' => '2026-10-15',
                'end_date' => '2026-11-30',
            ],
        ];
    }

    public static function galleries(): array
    {
        return [
            ['id' => 1, 'image' => null, 'caption' => 'Suasana indoor yang cozy'],
            ['id' => 2, 'image' => null, 'caption' => 'Sudut favorit untuk nugas'],
            ['id' => 3, 'image' => null, 'caption' => 'Barista kami sedang beraksi'],
            ['id' => 4, 'image' => null, 'caption' => 'Area outdoor di sore hari'],
        ];
    }

    public static function sampleOrder(): array
    {
        return [
            'order_code' => 'KAFE-001',
            'customer_name' => 'Budi Santoso',
            'table_number' => '3',
            'notes' => 'Gula dipisah ya',
            'status' => 'baru',
            'total_price' => 33000,
            'items' => [
                ['item_name' => 'Kopi Susu', 'unit_price' => 18000, 'quantity' => 1],
                ['item_name' => 'Kentang Goreng', 'unit_price' => 15000, 'quantity' => 1],
            ],
        ];
    }

    public static function findMenu(int $id): ?array
    {
        foreach (self::menuItems() as $menu) {
            if ($menu['id'] === $id) {
                return $menu;
            }
        }

        return null;
    }
}
