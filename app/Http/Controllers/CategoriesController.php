<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryControllerInterface;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class CategoriesController extends Controller implements CategoryControllerInterface
{
    public function uuidGenerator($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function showAll()
    {
        $allCategories = Category::readCategories();
        return new JsonResponse($allCategories, 200);
    }

    public function showOne(int $id) {}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required',
            'category' => 'required',
            'status' => 'required',
            'description' => 'required'
        ]);

        $file = base64_decode(explode(',', $validatedData['image'])[1]);
        $category = $validatedData['category'];
        $status = $validatedData['status'];
        $description = $validatedData['description'];

        $fileName = $this->uuidGenerator();

        Storage::disk('local')->put($fileName, $file);
        $path = Storage::disk('local')->path($fileName);

        $lastFileId = File::createImage($path);

        $lastCategoryId = Category::createCategory($category, $status, $description, $lastFileId);

        return new JsonResponse(['categoryId' => $lastCategoryId, 'fileId' => $lastFileId], 201);
    }

    public function update(int $id, array $data) {}

    public function destroy(int $id) {}
}
