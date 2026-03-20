<?php

namespace Tests\Feature;

use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Tests\TestCase;

class QuantityTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_to_cart_rejects_quantity_greater_than_variant_stock(): void
    {
        $productId = DB::table('products')->insertGetId([
            'name' => 'Test Hoodie',
            'slug' => 'test-hoodie',
            'description' => 'Scenario test product',
            'regular_price' => 49.99,
            'sale_price' => null,
            'SKU' => 'TH-BASE-001',
            'stock_status' => 'instock',
            'quantity' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ProductVariant::create([
            'product_id' => $productId,
            'size' => 'M',
            'color' => 'Black',
            'SKU' => 'TH-M-BLK-001',
            'quantity' => 1,
            'stock_status' => 'instock',
        ]);

        $response = $this->from('/shop/test-hoodie')->post('/cart/add', [
            'id' => $productId,
            'name' => 'Test Hoodie',
            'quantity' => 3,
            'price' => 49.99,
            'size' => 'M',
            'color' => 'Black',
        ]);

        $response->assertRedirect('/shop/test-hoodie');
        $response->assertSessionHas('error', 'Requested quantity exceeds available stock for the selected variant.');
        $this->assertSame(0, Cart::instance('cart')->content()->count());
    }
}
