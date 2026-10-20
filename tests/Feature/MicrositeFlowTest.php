<?php

namespace Tests\Feature;

use Tests\TestCase;

class MicrositeFlowTest extends TestCase
{
    public function test_home_page_loads_with_dummy_data(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Kafe Colab');
        $response->assertSee('Kopi Susu');
        $response->assertSee('Happy Hour');
    }

    public function test_menu_list_and_filter(): void
    {
        $this->get('/menu')->assertOk()->assertSee('Kopi Susu');
        $this->get('/menu?kategori=1')->assertOk()->assertSee('Matcha Latte');
        $this->get('/menu/1')->assertOk()->assertSee('Kopi Susu');
        $this->get('/menu/6')->assertNotFound(); // is_available = false
        $this->get('/menu/999')->assertNotFound();
    }

    public function test_cart_checkout_flow(): void
    {
        // tambah ke keranjang
        $this->post('/keranjang/1', ['qty' => 2])->assertRedirect(route('cart.index'));
        $this->get('/keranjang')->assertOk()->assertSee('Kopi Susu');

        // ubah qty
        $this->patch('/keranjang/1', ['qty' => 1])->assertRedirect(route('cart.index'));

        // checkout
        $this->get('/checkout')->assertOk()->assertSee('Checkout');
        $response = $this->post('/checkout', [
            'customer_name' => 'Dzacky',
            'table_number' => '5',
            'customer_phone' => '08123456789',
            'notes' => 'Es dikit',
        ]);
        $response->assertRedirect();
        $this->followRedirects($response)->assertOk()->assertSee('Pesanan Diterima');

        // keranjang dikosongkan setelah checkout
        $this->get('/keranjang')->assertOk()->assertSee('masih kosong');
    }

    public function test_checkout_empty_cart_redirects(): void
    {
        $this->get('/checkout')->assertRedirect(route('menu.index'));
        $this->post('/checkout', ['customer_name' => 'X'])->assertRedirect(route('menu.index'));
    }

    public function test_track_order_with_sample_code(): void
    {
        $this->get('/lacak')->assertOk()->assertSee('Lacak Pesanan');
        $this->get('/lacak?kode=KAFE-001')->assertOk()->assertSee('Budi Santoso');
        $this->get('/lacak?kode=SALAH')->assertOk()->assertSee('tidak ditemukan');
    }
}
