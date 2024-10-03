<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Interfaces\ProductControllerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller implements ProductControllerInterface
{
    public function showAll(Request $request)
    {

        $limit = intval($request->query('limit'));
        $page = intval($request->query('page'));
        $sortBy = strval($request->query('sortBy'));
        $filterBy = strval($request->query('filterBy'));
        $search = strval($request->query('search', ""));

        $offset = ($page - 1) * $limit;

        $products = Product::readProducts($offset, $limit, $sortBy, $filterBy, $search);
        $countProducts = Product::getCount($sortBy, $filterBy, $search);
        // $countProducts = $this->db->getCount($sort, $filter, $search);
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

        if ($product === null) {
            return new Response("not ok", 404);
        }
        return new JsonResponse($product, 200);
    }

    public function store(Request $request)
    {
        // try {
        // var_dump($request->json());


        $validatedData = $request->validate([
            'price' => 'required',
            'name' =>   'required|min:3',
            'status' => 'required',
            'description' => 'required|min:3',
            'categoryId' => 'required'
        ]);

        $price = $validatedData["price"];
        $name = $validatedData["name"];
        $status = $validatedData["status"];
        $description = $validatedData["description"];
        $categoryId = $validatedData["categoryId"];

        $lastId = Product::createProduct(
            $name,
            $price,
            $status,
            $description,
            $categoryId
        );


        return new JsonResponse($lastId, 201);
        // } catch (ValidationException $e) {
        //     return new JsonResponse(["error" => $e->getMessage()], 400);
        // }
    }

    public function update(Request $request, int $id)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $description = $validatedData["description"];
        $price = $validatedData["price"];
        $name = $validatedData["name"];
        $status = $validatedData["status"];

        Product::updateProduct($id, $name, $price, $description, $status);

        return new JsonResponse("ok", 200);
    }

    public function destroy(int $id)
    {
        // header('Content-Type: application/json');
        // $this->db->deleteProduct($id);
    }
}
