<?php

namespace Tests\Unit;

use App\Models\ProductVariant;
use PHPUnit\Framework\TestCase;

class ProductVariantGalleryArrayTest extends TestCase
{
    public function test_gallery_array_is_cleaned(): void
    {
        $variant = new ProductVariant();
        $variant->images = 'front.jpg, side.jpg, ,back.jpg';

        $this->assertSame(['front.jpg', 'side.jpg', 'back.jpg'], $variant->gallery_array);
    }
}
