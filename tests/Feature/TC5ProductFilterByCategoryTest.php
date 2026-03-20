<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TC5ProductFilterByCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_category_filter_returns_only_selected_category_products(): void
    {
        $womensCategoryId = DB::table('categories')->insertGetId([
            'name' => 'Womens',
            'slug' => 'womens',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mensCategoryId = DB::table('categories')->insertGetId([
            'name' => 'Mens',
            'slug' => 'mens',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('products')->insert([
            [
                'name' => 'Women Coat',
                'slug' => 'women-coat',
                'description' => 'Womens product',
                'regular_price' => 80,
                'sale_price' => null,
                'SKU' => 'TC5-W',
                'stock_status' => 'instock',
                'quantity' => 5,
                'category_id' => $womensCategoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Men Coat',
                'slug' => 'men-coat',
                'description' => 'Mens product',
                'regular_price' => 80,
                'sale_price' => null,
                'SKU' => 'TC5-M',
                'stock_status' => 'instock',
                'quantity' => 5,
                'category_id' => $mensCategoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/shop?categories='.$womensCategoryId);
        $response->assertOk();
        $response->assertSee('Women Coat');
        $response->assertDontSee('Men Coat');
    }
}
