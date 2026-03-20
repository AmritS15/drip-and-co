<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TC6PriceRangeFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_price_filter_shows_only_products_in_range(): void
    {
        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Filter Category',
            'slug' => 'filter-category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $brandId = DB::table('brands')->insertGetId([
            'name' => 'Filter Brand',
            'slug' => 'filter-brand',
            'category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('products')->insert([
            [
                'name' => 'In Range Product',
                'slug' => 'in-range-product',
                'description' => 'Within range',
                'regular_price' => 200,
                'sale_price' => 50,
                'SKU' => 'TC6-IN',
                'stock_status' => 'instock',
                'quantity' => 5,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Out Range Product',
                'slug' => 'out-range-product',
                'description' => 'Outside range',
                'regular_price' => 150,
                'sale_price' => 120,
                'SKU' => 'TC6-OUT',
                'stock_status' => 'instock',
                'quantity' => 5,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/shop?min=23&max=105');
        $response->assertOk();
        $response->assertSee('In Range Product');
        $response->assertDontSee('Out Range Product');
    }
}
