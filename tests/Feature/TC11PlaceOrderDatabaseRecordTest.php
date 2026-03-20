<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Tests\TestCase;

class TC11PlaceOrderDatabaseRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_place_order_creates_order_with_subtotal_tax_total_and_user_id(): void
    {
        $user = User::factory()->create([
            'mobile' => '07000000011',
        ]);

        $productId = DB::table('products')->insertGetId([
            'name' => 'Order Product',
            'slug' => 'order-product',
            'description' => 'Order flow product',
            'regular_price' => 100,
            'sale_price' => null,
            'SKU' => 'TC11-P',
            'stock_status' => 'instock',
            'quantity' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $address = Address::create([
            'user_id' => $user->id,
            'name' => 'Checkout User',
            'phone' => '07123456780',
            'locality' => 'Town',
            'address' => '1 Test Road',
            'city' => 'London',
            'state' => 'London',
            'country' => 'United Kingdom',
            'zip' => 'SW1A 1AA',
            'isdefault' => true,
        ]);

        Cart::instance('cart')->add($productId, 'Order Product', 1, 100.00, [
            'product_id' => $productId,
        ])->associate('App\Models\Product');

        $response = $this->actingAs($user)->post('/place-an-order', [
            'address_id' => $address->id,
            'mode' => 'cod',
        ]);

        $response->assertRedirect('/order-confirmation');
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'name' => 'Checkout User',
        ]);

        $order = DB::table('orders')->latest('id')->first();
        $this->assertNotNull($order);
        $this->assertNotNull($order->subtotal);
        $this->assertNotNull($order->tax);
        $this->assertNotNull($order->total);
    }
}
