<?php

namespace Tests\Feature;

use App\Models\Microsite;
use Tests\Concerns\CreatesMicrositeSchema;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use CreatesMicrositeSchema;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Route "/" dilindungi middleware ResolveMicrosite, jadi minimal
        // satu microsite aktif harus tersedia agar halaman home ter-render.
        $this->createMicrositeSchema();

        Microsite::create([
            'name' => 'Kafe Contoh',
            'slug' => 'kafe',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
