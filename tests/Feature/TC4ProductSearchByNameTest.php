<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TC4ProductSearchByNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_products_matching_name_query(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Green Jumper',
                'slug' => 'green-jumper',
                'description' => 'Searchable product',
                'regular_price' => 60,
                'sale_price' => null,
                'SKU' => 'TC4-GREEN',
                'stock_status' => 'instock',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blue Jacket',
                'slug' => 'blue-jacket',
                'description' => 'Non-matching product',
                'regular_price' => 70,
                'sale_price' => null,
                'SKU' => 'TC4-BLUE',
                'stock_status' => 'instock',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->getJson('/search?query=green%20jumper');
        $response->assertOk();
        $response->assertJsonFragment(['name' => 'Green Jumper']);
        $response->assertJsonMissing(['name' => 'Blue Jacket']);
    }
}
