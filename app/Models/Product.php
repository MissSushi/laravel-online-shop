<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public static function getCount(string $sort, string $filter, string $search)
    {
        $validSortColumns = [
            'id' => 'id',
            'name' => 'productName',
            'price' => 'price',
        ];

        if (!array_key_exists($sort, $validSortColumns)) {
            $sort = 'id';
        }

        if ($filter == "active") {
            $result = Product::where("status", 1)
                ->where(function (Builder $query) use ($search) {
                    $query->where("id", $search)
                        ->orWhere('name', 'like', '%' . $search . '%');
                })
                ->count();
        } elseif ($filter == "inactive") {
            $result = Product::where("status", 0)
                ->where(function (Builder $query) use ($search) {
                    $query->where("id", $search)
                        ->orWhere('name', 'like', '%' . $search . '%');
                })
                ->count();
        } else {
            $result = Product::where(function (Builder $query) use ($search) {
                $query->where("id", $search)
                    ->orWhere('name', 'like', '%' . $search . '%');
            })
                ->count();
            return $result;
        }
    }

    public static function readProducts(int $offset, int $limit, string $sort, string $filter, string $search)
    {
        $validSortColumns = [
            'id' => 'id',
            'name' => 'name',
            'price' => 'price',
        ];

        if (!array_key_exists($sort, $validSortColumns)) {
            $sort = 'id';
        }

        if ($filter == "active") {
            $result = Product::select("products.id", "products.name", "categories.name as category_name", "products.price", "products.status")
                ->join("categories", "products.category_id", "=", "categories.id")
                ->where("products.status", 1)
                ->where(function (Builder $query) use ($search) {
                    $query->where("products.id", $search)
                        ->orWhere('products.name', 'like', '%' . $search . '%');
                })
                ->orderBy("products." . $validSortColumns[$sort])
                ->limit($limit)
                ->offset($offset)
                ->get();
        } elseif ($filter == "inactive") {
            $result = Product::select("products.id", "products.name", "categories.name as category_name", "products.price", "products.status")
                ->join("categories", "products.category_id", "=", "categories.id")
                ->where("products.status", 0)
                ->where(function (Builder $query) use ($search) {
                    $query->where("products.id", $search)
                        ->orWhere('products.name', 'like', '%' . $search . '%');
                })
                ->orderBy("products." . $validSortColumns[$sort])
                ->limit($limit)
                ->offset($offset)
                ->get();
        } else {
            $result = Product::select("products.id", "products.name", "categories.name as category_name", "products.price", "products.status")
                ->join("categories", "products.category_id", "=", "categories.id")
                ->where(function (Builder $query) use ($search) {
                    $query->where("products.id", $search)
                        ->orWhere('products.name', 'like', '%' . $search . '%');
                })
                ->orderBy("products." . $validSortColumns[$sort])
                ->limit($limit)
                ->offset($offset)
                ->get();
        }
        return $result;
    }

    public static function readProduct(int $id)
    {
        return Product::findOrFail($id);
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

    public static function updateProduct(int $id, string $name, int $price, string $description, int $status, int $categoryId)
    {
        Product::where('id', $id)->update(['name' => $name, 'price' => $price, 'description' => $description, 'status' => $status, 'category_id' => $categoryId]);
    }

    public static function deleteProduct(int $id)
    {
        $result = Product::findOrFail($id)->delete();
        return $result;
    }
}
