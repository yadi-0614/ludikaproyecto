<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ProductSeeder
     */
    public function run(): void
    {
        Product::factory()->count(2)->create();
    }
}
