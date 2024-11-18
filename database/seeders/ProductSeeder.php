<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\File;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        File::factory()->count(5)->create();
        Category::factory()->count(3)->create();
        Product::factory()->count(10)->create();
    }
}
