<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Product;

$productIds = [13, 14];
$products = Product::whereIn('id', $productIds)->get(['id','ten','mota']);
foreach ($products as $product) {
    echo "ID={$product->id}\n";
    echo "ten={$product->ten}\n";
    echo "mota={$product->mota}\n";
    echo "contains áo in ten? ".(stripos($product->ten, 'áo') !== false ? 'yes' : 'no')."\n";
    echo "contains áo in mota? ".(stripos($product->mota ?? '', 'áo') !== false ? 'yes' : 'no')."\n";
    echo "----\n";
}
