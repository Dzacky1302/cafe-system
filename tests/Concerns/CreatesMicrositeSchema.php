<?php

namespace Tests\Concerns;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Skema minimal microsite (sama dengan hasil migration di database/migrations)
 * yang dibuat di koneksi SQLite in-memory, supaya test tidak bergantung
 * pada MySQL lokal.
 */
trait CreatesMicrositeSchema
{
    protected function createMicrositeSchema(): void
    {
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
    }
}
