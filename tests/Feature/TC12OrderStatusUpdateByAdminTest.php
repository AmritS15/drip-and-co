<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TC12OrderStatusUpdateByAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_order_status_to_delivered(): void
    {
        $admin = User::factory()->create([
            'mobile' => '07000000012',
            'utype' => 'ADM',
        ]);

        $customer = User::factory()->create([
            'mobile' => '07000000013',
        ]);

        $productId = DB::table('products')->insertGetId([
            'name' => 'Status Product',
            'slug' => 'status-product',
            'description' => 'Status test product',
            'regular_price' => 75,
            'sale_price' => null,
            'SKU' => 'TC12-P',
            'stock_status' => 'instock',
            'quantity' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $orderId = DB::table('orders')->insertGetId([
            'user_id' => $customer->id,
            'subtotal' => 75,
            'discount' => 0,
            'tax' => 0,
            'total' => 75,
            'name' => 'Order Customer',
            'phone' => '07123456781',
            'locality' => 'Town',
            'address' => '2 Test Road',
            'city' => 'London',
            'state' => 'London',
            'country' => 'United Kingdom',
            'zip' => 'SW1A 1AB',
            'status' => 'ordered',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('order_items')->insert([
            'product_id' => $productId,
            'order_id' => $orderId,
            'price' => 75,
            'quantity' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('transactions')->insert([
            'user_id' => $customer->id,
            'order_id' => $orderId,
            'mode' => 'cod',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($admin)->from('/admin/orders')->put('/admin/order/update-status', [
            'order_id' => $orderId,
            'order_status' => 'delivered',
        ]);

        $response->assertRedirect('/admin/orders');
        $this->assertDatabaseHas('orders', [
            'id' => $orderId,
            'status' => 'delivered',
        ]);
        $this->assertDatabaseHas('transactions', [
            'order_id' => $orderId,
            'status' => 'approved',
        ]);
    }
}
