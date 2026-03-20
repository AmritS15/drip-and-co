<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Tests\TestCase;

class TC8CartQuantityUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_item_quantity_updates_correctly(): void
    {
        Cart::instance('cart')->add(1, 'Quantity Product', 1, 25.00, [
            'product_id' => 1,
        ])->associate('App\Models\Product');

        $rowId = Cart::instance('cart')->content()->first()->rowId;

        $response = $this->put('/cart/update-quantity/'.$rowId, [
            'quantity' => 3,
        ]);

        $response->assertRedirect();
        $updatedItem = Cart::instance('cart')->get($rowId);
        $this->assertSame(3, (int) $updatedItem->qty);
    }
}
