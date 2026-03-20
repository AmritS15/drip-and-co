<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductSizeColorCastingTest extends TestCase
{
    public function test_sizes_and_colors_cast_correctly(): void
    {
        $product = new Product();

        $product->sizes = ['S', 'M', 'L'];
        $product->colors = ['Black', 'Yellow'];

        $this->assertSame('S,M,L', $product->getAttributes()['sizes']);
        $this->assertSame('Black,Yellow', $product->getAttributes()['colors']);

        $this->assertSame(['S', 'M', 'L'], $product->sizes);
        $this->assertSame(['Black', 'Yellow'], $product->colors);
    }
}
