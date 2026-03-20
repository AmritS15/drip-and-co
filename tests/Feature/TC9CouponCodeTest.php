<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Tests\TestCase;

class TC9CouponCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_coupon_applies_discount_session(): void
    {
        DB::table('coupons')->insert([
            'code' => 'SAVE10',
            'type' => 'fixed',
            'value' => 10,
            'cart_value' => 20,
            'expiry_date' => Carbon::tomorrow()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cart::instance('cart')->add(1, 'Coupon Product', 1, 50.00, [
            'product_id' => 1,
        ])->associate('App\Models\Product');

        $response = $this->from('/cart')->post('/cart/apply-coupon', [
            'coupon_code' => 'SAVE10',
        ]);

        $response->assertRedirect('/cart');
        $response->assertSessionHas('coupon');
        $response->assertSessionHas('discounts');
    }
}
