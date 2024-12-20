<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Interfaces\ProductControllerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller implements ProductControllerInterface
{
    public function validation(Request $request): array
    {
        $validatedData = $request->validate($request, [
            'price' => 'required',
            'name' =>   'required|min:3',
            'status' => 'required',
            'description' => 'required|min:3',
            'categoryId' => 'required'
        ]);

        return $validatedData;
    }
    public function showAll(Request $request)
    {
        $limit = intval($request->query('limit', 10));
        $page = intval($request->query('page', 1));
        $sortBy = strval($request->query('sortBy', 'all'));
        $filterBy = strval($request->query('filterBy', 'all'));
        $search = strval($request->query('search', ""));

        $offset = ($page - 1) * $limit;

        $products = Product::readProducts($offset, $limit, $sortBy, $filterBy, $search);
        $countProducts = Product::getCount($sortBy, $filterBy, $search);
        $countPages = ceil($countProducts / $limit);
        return new JsonResponse([
            'products' => $products,
            'count' => $countProducts,
            'countPages' => $countPages,
            'products' => $products
        ]);
    }

    public function showOne(int $id)
    {
        $product = Product::readProduct($id);
        return new JsonResponse($product, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validation($request);

        $price = $validatedData["price"];
        $name = $validatedData["name"];
        $status = $validatedData["status"];
        $description = $validatedData["description"];
        $categoryId = $validatedData["categoryId"];

        try {
            $lastId = Product::createProduct(
                $name,
                $price,
                $status,
                $description,
                $categoryId
            );
            return new JsonResponse($lastId, 201);
        } catch (\Exception $error) {
            return new JsonResponse(['message' => 'Failed to create product', 'error' => $error->getMessage()], 500);
        }
    }



    public function update(Request $request, int $id)
    {
        $validatedData = $this->validation($request);

        $description = $validatedData["description"];
        $price = $validatedData["price"];
        $name = $validatedData["name"];
        $status = $validatedData["status"];
        $categoryId = $validatedData["categoryId"];

        try {
            Product::updateProduct($id, $name, $price, $description, $status, $categoryId);
            return new JsonResponse(['message' => 'Product updated successfully', 'success' => true], 200);
        } catch (\Exception $error) {
            return new JsonResponse(['message' => 'Failed to update product', 'error' => $error->getMessage()], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            Product::deleteProduct($id);
            return new JsonResponse(['message' => 'Product deleted successfully', 'success' => true], 200);
        } catch (ModelNotFoundException $error) {
            return new JsonResponse(['message' => 'Failed to delete product', 'error' => $error->getMessage()], 500);
        }
    }
}
