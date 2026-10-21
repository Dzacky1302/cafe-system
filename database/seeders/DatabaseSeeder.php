<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Idempotent: aman dijalankan berulang tanpa bentrok unique email.
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
            ]
        );

        // Data microsite (kategori, menu, promo, pesanan) ke DB microsite_db.
        $this->call(MicrositeSeeder::class);
    }
}
