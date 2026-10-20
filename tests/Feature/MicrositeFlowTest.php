<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Microsite;
use App\Models\Promo;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MicrositeFlowTest extends TestCase
{
    private Microsite $kafe;
    private Microsite $restoran;
    private MenuItem $kopi;
    private MenuItem $mieLab;
    private MenuItem $menuRestoran;

    protected function setUp(): void
    {
        parent::setUp();

        // Skema minimal milik admin-panel (microsite_db) dibuat in-memory
        // agar test tidak bergantung pada MySQL lokal.
        Schema::create('microsites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->string('table_number')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['baru', 'diproses', 'siap', 'selesai', 'dibatalkan'])->default('baru');
            $table->unsignedInteger('total_price');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_item_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_name');
            $table->unsignedInteger('unit_price');
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });

        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        $this->kafe = Microsite::create([
            'name' => 'Kafe Colab',
            'slug' => 'kafe',
            'settings' => ['address' => 'Jl. Kolaborasi No. 9', 'open_hours' => '08.00 - 22.00', 'phone' => '0812-0000-0000'],
        ]);

        $this->restoran = Microsite::create(['name' => 'Restoran Contoh', 'slug' => 'restoran']);

        $minuman = Category::create(['microsite_id' => $this->kafe->id, 'name' => 'Minuman', 'sort_order' => 1]);
        $utama = Category::create(['microsite_id' => $this->restoran->id, 'name' => 'Makanan Utama', 'sort_order' => 1]);

        $this->kopi = MenuItem::create([
            'microsite_id' => $this->kafe->id,
            'category_id' => $minuman->id,
            'name' => 'Kopi Susu',
            'price' => 18000,
        ]);

        $this->mieLab = MenuItem::create([
            'microsite_id' => $this->kafe->id,
            'category_id' => $minuman->id,
            'name' => 'Mie Goreng Lab',
            'price' => 20000,
            'is_available' => false,
        ]);

        $this->menuRestoran = MenuItem::create([
            'microsite_id' => $this->restoran->id,
            'category_id' => $utama->id,
            'name' => 'Nasi Goreng Restoran',
            'price' => 28000,
        ]);

        Promo::create([
            'microsite_id' => $this->kafe->id,
            'title' => 'Happy Hour',
            'description' => 'Diskon 20% kopi',
            'start_date' => '2026-01-01',
            'end_date' => '2030-12-31',
        ]);

        Gallery::create(['microsite_id' => $this->kafe->id, 'image' => 'menu/suasana.jpg', 'caption' => 'Suasana kafe']);
    }

    public function test_home_page_shows_only_cafe_data(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Kafe Colab');
        $response->assertSee('Kopi Susu');
        $response->assertSee('Happy Hour');
        $response->assertSee('Jl. Kolaborasi No. 9');
        // Isolasi microsite: data restoran tidak boleh bocor.
        $response->assertDontSee('Nasi Goreng Restoran');
    }

    public function test_menu_list_filter_and_isolation(): void
    {
        $this->get('/menu')
            ->assertOk()
            ->assertSee('Kopi Susu')
            ->assertDontSee('Mie Goreng Lab')
            ->assertDontSee('Nasi Goreng Restoran');

        $this->get('/menu?kategori='.$this->minumanId())
            ->assertOk()
            ->assertSee('Kopi Susu');

        $this->get('/menu/'.$this->kopi->id)->assertOk()->assertSee('Kopi Susu');
        $this->get('/menu/'.$this->mieLab->id)->assertNotFound();
        $this->get('/menu/'.$this->menuRestoran->id)->assertNotFound();
    }

    public function test_checkout_saves_order_to_database(): void
    {
        $this->post('/keranjang/'.$this->kopi->id, ['qty' => 2])->assertRedirect(route('cart.index'));

        $response = $this->post('/checkout', [
            'customer_name' => 'Dzacky',
            'customer_phone' => '08123456789',
            'table_number' => '5',
            'notes' => 'Es dikit',
        ]);

        $response->assertRedirect();

        $order = DB::table('orders')->where('customer_name', 'Dzacky')->first();

        $this->assertNotNull($order);
        $this->assertSame($this->kafe->id, $order->microsite_id);
        $this->assertSame('baru', $order->status);
        $this->assertSame(36000, (int) $order->total_price);
        $this->assertStringStartsWith('KAFE-', $order->order_code);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'microsite_id' => $this->kafe->id,
            'menu_item_id' => $this->kopi->id,
            'item_name' => 'Kopi Susu',
            'unit_price' => 18000,
            'quantity' => 2,
        ]);

        // Keranjang dikosongkan setelah checkout.
        $this->get('/keranjang')->assertOk()->assertSee('masih kosong');
    }

    public function test_checkout_empty_cart_redirects(): void
    {
        $this->get('/checkout')->assertRedirect(route('menu.index'));
        $this->post('/checkout', ['customer_name' => 'X'])->assertRedirect(route('menu.index'));
    }

    public function test_track_order_by_code_with_scope(): void
    {
        $orderId = DB::table('orders')->insertGetId([
            'microsite_id' => $this->kafe->id,
            'order_code' => 'KAFE-TEST',
            'customer_name' => 'Budi Santoso',
            'table_number' => '3',
            'status' => 'baru',
            'total_price' => 18000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('order_items')->insert([
            'order_id' => $orderId,
            'microsite_id' => $this->kafe->id,
            'menu_item_id' => $this->kopi->id,
            'item_name' => 'Kopi Susu',
            'unit_price' => 18000,
            'quantity' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Order milik microsite restoran tidak boleh bisa dilacak dari kafe.
        DB::table('orders')->insert([
            'microsite_id' => $this->restoran->id,
            'order_code' => 'RESTO-001',
            'customer_name' => 'Siti Rahma',
            'status' => 'baru',
            'total_price' => 28000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->get('/lacak?kode=KAFE-TEST')
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee('Kopi Susu');

        $this->get('/lacak?kode=RESTO-001')
            ->assertOk()
            ->assertSee('tidak ditemukan');

        $this->get('/lacak?kode=SALAH')->assertOk()->assertSee('tidak ditemukan');
    }

    private function minumanId(): int
    {
        return Category::where('name', 'Minuman')->first()->id;
    }
}
