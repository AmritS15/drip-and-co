<?php

namespace Tests\Feature;

use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Tests\TestCase;

class TC10AddToCartDatabaseIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_to_cart_stores_variant_id_size_color_and_quantity_in_cart_session(): void
    {
        $productId = DB::table('products')->insertGetId([
            'name' => 'Variant Product',
            'slug' => 'variant-product',
            'description' => 'Cart integration product',
            'regular_price' => 40,
            'sale_price' => null,
            'SKU' => 'TC10-P',
            'stock_status' => 'instock',
            'quantity' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $variant = ProductVariant::create([
            'product_id' => $productId,
            'size' => 'M',
            'color' => 'Yellow',
            'SKU' => 'TC10-V',
            'quantity' => 8,
            'stock_status' => 'instock',
        ]);

        $response = $this->from('/shop/variant-product')->post('/cart/add', [
            'id' => $productId,
            'name' => 'Variant Product',
            'quantity' => 2,
            'price' => 40,
            'size' => 'M',
            'color' => 'Yellow',
        ]);

        $response->assertRedirect('/shop/variant-product');

        $item = Cart::instance('cart')->content()->first();
        $this->assertNotNull($item);
        $this->assertSame(2, (int) $item->qty);
        $this->assertSame($variant->id, (int) $item->options['variant_id']);
        $this->assertSame('M', (string) $item->options['size']);
        $this->assertSame('Yellow', (string) $item->options['color']);
    }
}
