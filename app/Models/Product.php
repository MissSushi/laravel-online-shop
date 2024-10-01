<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public static function readProducts()
    {
        $products = Product::all(["name", "price", "status"]);
        return $products->toArray();
    }

    public static function createProduct(string $name, int $price, int $status, string $description, int $categoryId): int
    {
        $product = new Product();
        $product->name = $name;
        $product->price = $price;
        $product->status = $status;
        $product->description = $description;
        $product->category_id = $categoryId;

        $product->save();

        $last_id = $product->id;
        return $last_id;
    }
}
