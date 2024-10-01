<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static function createCategory(string $name, int $status, string $description, int $imageId)
    {

        $category = new Category();

        $category->name = $name;
        $category->status = $status;
        $category->description = $description;
        $category->file_id = $imageId;

        $category->save();

        $last_id = $category->id;
        return $last_id;
    }

    public static function readCategories()
    {

        $allCategories = Category::select("*")->get();
        return $allCategories;
    }
}
