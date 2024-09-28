<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public static function createImage(string $filePath)
    {

        $file = new File();

        $file->file_path = $filePath;
        $file->save();

        $last_id = $file->id;
        return $last_id;
    }
}
