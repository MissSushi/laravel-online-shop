<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductControllerInterface
{
    public function showAll(Request $request);

    public function showOne(int $id);

    public function store(Request $request);

    public function update(int $id, array $data);

    public function destroy(int $id);
}
