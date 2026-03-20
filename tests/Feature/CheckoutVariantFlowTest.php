<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Tests\TestCase;

class CheckoutVariantFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_variant_order_item_and_reduces_variant_stock(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'mobile' => '07333333333',
        ]);

        $productId = DB::table('products')->insertGetId([
            'name' => 'Yellow Jacket',
            'slug' => 'yellow-jacket',
            'description' => 'Test product description',
            'regular_price' => 99.99,
            'sale_price' => null,
            'SKU' => 'YJ-BASE-001',
            'stock_status' => 'instock',
            'quantity' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $variant = ProductVariant::create([
            'product_id' => $productId,
            'size' => 'M',
            'color' => 'Yellow',
            'SKU' => 'YJ-M-YEL-001',
            'quantity' => 5,
            'stock_status' => 'instock',
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'name' => 'Test Customer',
            'phone' => '07123456789',
            'locality' => 'Town Centre',
            'address' => '10 Test Street',
            'city' => 'London',
            'state' => 'London',
            'country' => 'United Kingdom',
            'zip' => 'SW1A 1AA',
            'isdefault' => true,
        ]);

        Cart::instance('cart')->add(
            'variant-'.$variant->id,
            'Yellow Jacket',
            2,
            99.99,
            [
                'product_id' => $productId,
                'variant_id' => $variant->id,
                'size' => 'M',
                'color' => 'Yellow',
            ]
        )->associate('App\Models\Product');

        $response = $this->actingAs($user)->post('/place-an-order', [
            'address_id' => $address->id,
            'mode' => 'cod',
        ]);

        $response->assertRedirect('/order-confirmation');

        $this->assertDatabaseHas('order_items', [
            'product_id' => $productId,
            'quantity' => 2,
        ]);

        $orderItem = OrderItem::query()->latest('id')->first();
        $this->assertNotNull($orderItem);
        $this->assertStringContainsString('"variant_id":'.$variant->id, $orderItem->options ?? '');

        $variant->refresh();
        $this->assertSame(3, (int) $variant->quantity);
    }
}
