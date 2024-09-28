<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Interfaces\ProductControllerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller implements ProductControllerInterface
{
    public function showAll()
    {
        header('Content-Type: application/json');
        $products = Product::readProducts();
        // $countProducts = $this->db->getCount($sort, $filter, $search);
        // $countPages = ceil($countProducts / $limit);
        // echo json_encode([
        //     'count' => $countProducts,
        //     'countPages' => $countPages,
        //     'products' => $products
        // ]);

    }

    public function showOne(int $id)
    {
        // header('Content-Type: application/json');
        // $result = $this->db->getProduct($id);
        // if ($result === null) {
        //     http_response_code(404);
        // }
        // echo json_encode($result);

    }

    public function store(Request $request)
    {
        // try {
        // var_dump($request->json());


        $validatedData = $request->validate([
            'price' => 'required',
            'name' =>   'required|min:3',
            'status' => 'required',
            'description' => 'required|min:3'
        ]);

        $price = $validatedData["price"];
        $name = $validatedData["name"];
        $status = $validatedData["status"];
        $description = $validatedData["description"];

        $lastId = Product::createProduct(
            $name,
            $price,
            $status,
            $description
        );


        return new JsonResponse($lastId, 201);
        // } catch (ValidationException $e) {
        //     return new JsonResponse(["error" => $e->getMessage()], 400);
        // }
    }

    public function update(int $id, array $data)
    {
        // header('Content-Type: application/json');

        // $description = $item["description"];
        // $price = $item["price"];
        // $name = $item["name"];
        // $status = $item["status"];

        // $this->db->editProduct($id, $name, $description, $price, $status);
    }

    public function destroy(int $id)
    {
        // header('Content-Type: application/json');
        // $this->db->deleteProduct($id);
    }
}