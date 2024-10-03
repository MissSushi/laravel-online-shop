<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductControllerInterface
{
    public function showAll(Request $request);

    public function showOne(int $id);

    public function store(Request $request);

    public function update(Request $request, int $id);

    public function destroy(int $id);
}
