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
            $result = Product::select("id", "name", "price", "status")
                ->where("status", 1)
                ->where(function (Builder $query) use ($search) {
                    $query->where("id", $search)
                        ->orWhere('name', 'like', '%' . $search . '%');
                })
                ->orderBy($validSortColumns[$sort])
                ->limit($limit)
                ->offset($offset)
                ->get();
        } elseif ($filter == "inactive") {
            $result = Product::select("id", "name", "price", "status")
                ->where("status", 0)
                ->where(function (Builder $query) use ($search) {
                    $query->where("id", $search)
                        ->orWhere('name', 'like', '%' . $search . '%');
                })
                ->orderBy($validSortColumns[$sort])
                ->limit($limit)
                ->offset($offset)
                ->get();
        } else {
            $result = Product::select("id", "name", "price", "status")
                ->where(function (Builder $query) use ($search) {
                    $query->where("id", $search)
                        ->orWhere('name', 'like', '%' . $search . '%');
                })
                ->orderBy($validSortColumns[$sort])
                ->limit($limit)
                ->offset($offset)
                ->get();
        }
        return $result;
    }

    public static function readProduct(int $id)
    {
        $product = Product::findOrFail($id);
        return $product;
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

    public static function updateProduct(int $id, string $name, int $price, string $description, int $status)
    {
        Product::where('id', $id)->update(['name' => $name, 'price' => $price, 'description' => $description, 'status' => $status]);
    }
}
