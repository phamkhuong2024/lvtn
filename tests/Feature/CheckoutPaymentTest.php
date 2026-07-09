<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Color;
use App\Models\KhachHang;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_online_payment_creates_order_and_redirects_to_gateway_page(): void
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
            'mota' => 'Test',
            'noibat' => false,
            'trangthai' => true,
        ]);

        $color = Color::create(['ten' => 'Đỏ']);
        $size = Size::create(['ten' => 'M']);
        $variant = ProductVariant::create([
            'sanphamid' => $product->id,
            'mausacid' => $color->id,
            'kichcoid' => $size->id,
            'soluong' => 10,
            'gia' => 100000,
        ]);

        $customer = KhachHang::create([
            'tendangnhap' => 'testcustomer',
            'ten' => 'Khách hàng test',
            'email' => 'customer@example.com',
            'sdt' => '0123456789',
            'matkhau' => bcrypt('password'),
            'diachi' => '123 Test Street',
        ]);

        session(['cart' => [[
            'key' => $product->id . '_' . $color->id . '_' . $size->id,
            'product_id' => $product->id,
            'name' => $product->ten,
            'image' => null,
            'color_id' => $color->id,
            'color_name' => $color->ten,
            'size_id' => $size->id,
            'size_name' => $size->ten,
            'price' => $variant->gia,
            'quantity' => 1,
            'stock' => $variant->soluong,
        ]]]);

        $response = $this->actingAs($customer, 'khachhang')->post(route('checkout.place'), [
            'ten' => 'Khách hàng test',
            'email' => 'customer@example.com',
            'sdt' => '0123456789',
            'diachi' => '123 Test Street',
            'phuong' => 'Phường 1',
            'quan' => 'Quận 1',
            'thanhpho' => 'HCM',
            'phuongthuc' => 'stripe',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('thanh_toan', ['phuongthuc' => 'stripe', 'trangthai' => 'cho_thanh_toan']);
    }
}
