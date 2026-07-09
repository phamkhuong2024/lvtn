<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
foreach (['ao', 'áo'] as $search) {
    $count = App\Models\Product::where('trangthai', 1)->where('ten', 'like', "%{$search}%")->count();
    echo "{$search}: {$count}\n";
}
