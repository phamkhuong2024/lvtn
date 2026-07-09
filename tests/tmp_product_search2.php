<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Product;

foreach (['ao', 'áo'] as $search) {
    echo "SEARCH: {$search}\n";
    $products = Product::with(['category', 'type'])
        ->where('trangthai', 1)
        ->where(function ($q) use ($search) {
            $q->where('ten', 'like', "%{$search}%")
                ->orWhere('mota', 'like', "%{$search}%")
                ->orWhereHas('category', function ($q2) use ($search) {
                    $q2->where('ten', 'like', "%{$search}%");
                })
                ->orWhereHas('type', function ($q2) use ($search) {
                    $q2->where('ten', 'like', "%{$search}%");
                });
        })
        ->get();
    foreach ($products as $product) {
        echo "- ID={$product->id}, ten={$product->ten}, category=" . ($product->category?->ten ?? 'NULL') . ", type=" . ($product->type?->ten ?? 'NULL') . "\n";
    }
    echo "TOTAL: " . $products->count() . "\n\n";
}
