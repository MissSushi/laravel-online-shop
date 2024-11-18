<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryControllerInterface;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FilesController extends Controller implements CategoryControllerInterface
{
    public function showAll() {}

    public function showOne(int $id) {}

    public function store(Request $request) {}

    public function update(int $id, array $data) {}

    public function destroy(int $id) {}
}
