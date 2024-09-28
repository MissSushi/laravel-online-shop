<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments("id");
            $table->string("file_path");
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->integer("status");
            $table->text("description");
            $table->integer("file_id");
            $table->foreign("file_id")->references('id')->on("files")->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->decimal("price", 8, 2);
            $table->integer("status");
            $table->string("description");
            $table->integer("category_id");
            $table->foreign("category_id")->references("id")->on("categories")->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_file', function (Blueprint $table) {
            $table->integer("product_id");
            $table->integer("file_id");

            $table->foreign("product_id")->references("id")->on("products")->onDelete('cascade');
            $table->foreign("file_id")->references("id")->on("files")->onDelete('cascade');
            $table->primary(["product_id", "file_id"]);
            $table->timestamps();
        });
    }

    public function createFile(Blueprint $table) {}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_file');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('files');
    }
};
