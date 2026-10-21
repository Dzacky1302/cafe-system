<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Microsite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder data awal untuk microsite_db (XAMPP).
 *
 * Sengaja idempotent (updateOrCreate / firstOrCreate) supaya
 * `php artisan db:seed` aman dijalankan berkali-kali tanpa bentrok
 * unique constraint (slug microsite, email user, order_code, dll).
 *
 * Skema tabel mengikuti admin-panel, namun file admin-panel
 * tidak diubah sama sekali.
 */
class MicrositeSeeder extends Seeder
{
    public function run(): void
    {
        $kafe = Microsite::updateOrCreate(
            ['slug' => 'kafe'],
            [
                'name' => 'Kafe Contoh',
                'domain' => null,
                'is_active' => true,
                'settings' => [
                    'color' => '#8B5E3C',
                    'open_hours' => '08.00 - 22.00',
                ],
            ]
        );

        $restoran = Microsite::updateOrCreate(
            ['slug' => 'restoran'],
            [
                'name' => 'Restoran Contoh',
                'domain' => null,
                'is_active' => true,
                'settings' => [
                    'color' => '#B23A48',
                    'open_hours' => '10.00 - 21.00',
                ],
            ]
        );

        $this->seedAdmins($kafe, $restoran);
        $this->seedKafeContent($kafe);
        $this->seedRestoranContent($restoran);
        $this->seedOrders($kafe);
    }


    private function seedAdmins(Microsite $kafe, Microsite $restoran): void
    {
        $admins = [
            [
                'username' => 'superadmin',
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'microsite_id' => null,
            ],
            [
                'username' => 'admin_kafe',
                'name' => 'Admin Kafe',
                'role' => 'admin',
                'microsite_id' => $kafe->id,
            ],
            [
                'username' => 'admin_restoran',
                'name' => 'Admin Restoran',
                'role' => 'admin',
                'microsite_id' => $restoran->id,
            ],
        ];

        foreach ($admins as $admin) {
            DB::table('admins')->updateOrInsert(
                ['username' => $admin['username']],
                [
                    'name' => $admin['name'],
                    'role' => $admin['role'],
                    'password' => Hash::make('password123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            if ($admin['microsite_id'] === null) {
                continue;
            }

            $adminId = DB::table('admins')->where('username', $admin['username'])->value('id');

            DB::table('admin_microsite')->updateOrInsert(
                ['admin_id' => $adminId, 'microsite_id' => $admin['microsite_id']],
                []
            );
        }
    }


    private function seedKafeContent(Microsite $kafe): void
    {
        $minuman = Category::withoutGlobalScopes()->updateOrCreate(
            ['microsite_id' => $kafe->id, 'name' => 'Minuman'],
            ['sort_order' => 1]
        );

        $camilan = Category::withoutGlobalScopes()->updateOrCreate(
            ['microsite_id' => $kafe->id, 'name' => 'Camilan'],
            ['sort_order' => 2]
        );

        $makanan = Category::withoutGlobalScopes()->updateOrCreate(
            ['microsite_id' => $kafe->id, 'name' => 'Makanan'],
            ['sort_order' => 3]
        );

        $menus = [
            ['category_id' => $minuman->id, 'name' => 'Kopi Susu', 'description' => 'Kopi susu creamy dengan gula aren.', 'price' => 18000],
            ['category_id' => $minuman->id, 'name' => 'Americano', 'description' => 'Espresso single shot dengan air.', 'price' => 16000],
            ['category_id' => $minuman->id, 'name' => 'Matcha Latte', 'description' => 'Matcha premium dengan susu segar.', 'price' => 22000],
            ['category_id' => $camilan->id, 'name' => 'Kentang Goreng', 'description' => 'Kentang goreng renyah dengan saus.', 'price' => 15000],
            ['category_id' => $camilan->id, 'name' => 'Roti Bakar Cokelat', 'description' => 'Roti panggang dengan cokelat Belgia.', 'price' => 14000],
            ['category_id' => $makanan->id, 'name' => 'Nasi Goreng', 'description' => 'Nasi goreng khas dengan ayam.', 'price' => 25000],
        ];

        foreach ($menus as $menu) {
            MenuItem::withoutGlobalScopes()->updateOrCreate(
                ['microsite_id' => $kafe->id, 'name' => $menu['name']],
                [
                    'category_id' => $menu['category_id'],
                    'description' => $menu['description'],
                    'price' => $menu['price'],
                    'image' => null,
                    'is_available' => true,
                ]
            );
        }

        Gallery::withoutGlobalScopes()->updateOrCreate(
            ['microsite_id' => $kafe->id, 'image' => 'gallery/kafe-interior.jpg'],
            ['caption' => 'Interior Kafe Contoh']
        );

        Promo::withoutGlobalScopes()->updateOrCreate(
            ['microsite_id' => $kafe->id, 'title' => 'Promo Kopi Susu'],
            [
                'description' => 'Diskon 20% untuk Kopi Susu setiap hari kerja.',
                'start_date' => now()->startOfMonth()->toDateString(),
                'end_date' => now()->endOfMonth()->toDateString(),
            ]
        );
    }

    private function seedRestoranContent(Microsite $restoran): void
    {
        $utama = Category::withoutGlobalScopes()->updateOrCreate(
            ['microsite_id' => $restoran->id, 'name' => 'Makanan Utama'],
            ['sort_order' => 1]
        );

        $paket = Category::withoutGlobalScopes()->updateOrCreate(
            ['microsite_id' => $restoran->id, 'name' => 'Paket Keluarga'],
            ['sort_order' => 2]
        );

        $menus = [
            ['category_id' => $utama->id, 'name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng dengan seafood.', 'price' => 28000],
            ['category_id' => $utama->id, 'name' => 'Ayam Bakar Madu', 'description' => 'Ayam bakar dengan saus madu.', 'price' => 32000],
            ['category_id' => $paket->id, 'name' => 'Paket Keluarga 4 Orang', 'description' => 'Paket makan untuk 4 orang.', 'price' => 120000],
        ];

        foreach ($menus as $menu) {
            MenuItem::withoutGlobalScopes()->updateOrCreate(
                ['microsite_id' => $restoran->id, 'name' => $menu['name']],
                [
                    'category_id' => $menu['category_id'],
                    'description' => $menu['description'],
                    'price' => $menu['price'],
                    'image' => null,
                    'is_available' => true,
                ]
            );
        }
    }



    private function seedOrders(Microsite $kafe): void
    {
        $orders = [
            [
                'order_code' => 'KAFE-001',
                'customer_name' => 'Budi Santoso',
                'customer_phone' => null,
                'table_number' => '3',
                'notes' => 'Gula dipisah ya',
                'status' => 'baru',
                'total_price' => 33000,
                'items' => [
                    ['item_name' => 'Kopi Susu', 'unit_price' => 18000, 'quantity' => 1],
                    ['item_name' => 'Kentang Goreng', 'unit_price' => 15000, 'quantity' => 1],
                ],
            ],
            [
                'order_code' => 'KAFE-002',
                'customer_name' => 'Siti Rahma',
                'customer_phone' => '08123456789',
                'table_number' => '5',
                'notes' => null,
                'status' => 'diproses',
                'total_price' => 36000,
                'items' => [
                    ['item_name' => 'Kopi Susu', 'unit_price' => 18000, 'quantity' => 2],
                ],
            ],
        ];

        foreach ($orders as $data) {
            $order = Order::withoutGlobalScopes()->updateOrCreate(
                ['order_code' => $data['order_code']],
                [
                    'microsite_id' => $kafe->id,
                    'customer_name' => $data['customer_name'],
                    'customer_phone' => $data['customer_phone'],
                    'table_number' => $data['table_number'],
                    'notes' => $data['notes'],
                    'status' => $data['status'],
                    'total_price' => $data['total_price'],
                ]
            );

            foreach ($data['items'] as $item) {
                OrderItem::updateOrCreate(
                    ['order_id' => $order->id, 'item_name' => $item['item_name']],
                    [
                        'microsite_id' => $kafe->id,
                        'menu_item_id' => null,
                        'unit_price' => $item['unit_price'],
                        'quantity' => $item['quantity'],
                    ]
                );
            }
        }
    }
}
