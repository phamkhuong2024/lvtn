<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductAdminTest extends TestCase
{
    public function test_admin_products_page_is_available(): void
    {
        $response = $this->get('/admin/products');

        $response->assertStatus(200);
    }

    public function test_admin_create_product_page_is_available(): void
    {
        $response = $this->get('/admin/products/create');

        $response->assertStatus(200);
    }
}
