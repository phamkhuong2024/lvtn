<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_adding_product_to_cart_reduces_variant_stock(): void
    {
        $category = Category::create(['ten' => 'Áo', 'mota' => 'Test']);
        $type = ProductType::create([
            'danhmucid' => $category->id,
            'ten' => 'Thời trang',
            'mota' => 'Test',
            'hinhanh' => null,
            'noibat' => false,
        ]);

        $product = Product::create([
            'danhmucid' => $category->id,
            'loaisanphamid' => $type->id,
            'ten' => 'Áo test',
            'giaban' => 100000,
            'giagiam' => null,
            'hinhanh' => null,
            'mota' => 'Test product',
            'noibat' => false,
            'trangthai' => true,
        ]);

        $color = Color::create(['ten' => 'Đỏ']);
        $size = Size::create(['ten' => 'M']);

        $variant = ProductVariant::create([
            'sanphamid' => $product->id,
            'mausacid' => $color->id,
            'kichcoid' => $size->id,
            'soluong' => 5,
            'gia' => 100000,
        ]);

        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'color_id' => $color->id,
            'size_id' => $size->id,
            'quantity' => 2,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertSame(3, $variant->fresh()->soluong);
        $this->assertSame(2, collect(session('cart'))->first()['quantity']);
    }
}
