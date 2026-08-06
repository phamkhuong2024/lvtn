<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorySlugTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_slug_is_generated_from_name(): void
    {
        $category = Category::create([
            'ten' => 'Áo sơ mi',
            'mota' => 'Test category',
        ]);

        $this->assertSame('ao-so-mi', $category->refresh()->slug);
        $this->assertTrue(Category::where('slug', 'ao-so-mi')->exists());
    }
}
