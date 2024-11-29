<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    public function test_products_are_listed_correctly(): void
    {
        File::factory()->count(3)->create();
        Category::factory()->count(3)->create();
        Product::factory()->count(3)->create();
        $this->assertDatabaseCount('products', 3);

        $response = $this->get('/api/products');
        $response->assertOk();
        $response->assertJsonCount(3);
    }

    public function test_product_is_listed_correctly(): void
    {
        File::factory()->count(1)->create();
        Category::factory()->count(1)->create();
        $products = Product::factory()->count(1)->create();
        $id = $products[0]->id;

        $response = $this->getJson('api/products/' . $id);
        $response->assertOk();
    }

    public function test_product_not_found(): void
    {

        $this->assertDatabaseCount('products', 0);
        $response = $this->get('/api/products/50');
        $response->assertNotFound();
    }

    public function test_successful_product_creation(): void
    {
        File::factory()->count(1)->create();
        Category::factory()->count(1)->create();

        $payload = [
            'price' => 100,
            'name' => 'Test Product',
            'status' => 1,
            'description' => 'A great product',
            'categoryId' => 1,
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 100,
            'status' => 1,
            'description' => 'A great product',
            'category_id' => 1,
        ]);
    }

    public function test_product_creation_failed(): void
    {
        File::factory()->count(1)->create();
        Category::factory()->count(1)->create();

        $payload = [
            'price' => 100,
            'name' => 'Test Product',
            'status' => 1,
            'description' => 'A great product',
            'categoryId' => 200
        ];

        $response = $this->postJson('/api/products', $payload);
        $response->assertInternalServerError();
    }

    public function test_validation_errors_on_missing_fields()
    {
        $payload = [
            'name' => 'Short',
            'status' => 1,
            'description' => 'Short',
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['price', 'categoryId']);
    }

    public function test_successful_product_update(): void
    {
        File::factory()->count(1)->create();
        $categories = Category::factory()->count(1)->create();
        $products = Product::factory()->count(1)->create();

        $id = $products[0]->id;
        $categoryId = $categories[0]->id;

        $payload = [
            'price' => 100,
            'name' => 'Test Product',
            'status' => 1,
            'description' => 'A great product',
            'categoryId' => $categoryId,
        ];

        $response = $this->putJson('/api/products/' . $id, $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 100,
            'status' => 1,
            'description' => 'A great product',
            'category_id' => $categoryId,
        ]);
    }

    public function test_failed_product_update(): void
    {
        File::factory()->count(1)->create();
        Category::factory()->count(1)->create();
        $products = Product::factory()->count(1)->create();

        $id = $products[0]->id;

        $payload = [
            'price' => 100,
            'name' => 'Test Product',
            'status' => 1,
            'description' => 'A great product',
            'categoryId' => 500,
        ];

        $response = $this->putJson('/api/products/' . $id, $payload);
        $response->assertInternalServerError();
    }

    public function test_error_on_missing_fields(): void
    {
        File::factory()->count(1)->create();
        $categories = Category::factory()->count(1)->create();
        $products = Product::factory()->count(1)->create();

        $id = $products[0]->id;
        $categoryId = $categories[0]->id;

        $payload = [
            'name' => 'Test Product',
            'status' => 1,
            'description' => 'A great product',
            'categoryId' => $categoryId,
        ];

        $response = $this->putJson('/api/products/' . $id, $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['price']);
    }

    public function test_successful_product_deleted(): void
    {
        File::factory()->count(1)->create();
        Category::factory()->count(1)->create();
        $products = Product::factory()->count(1)->create();

        $id = $products[0]->id;

        $this->assertDatabaseCount("products", 1);

        $response = $this->deleteJson('/api/products/' . $id);
        $response->assertOk();

        $this->assertDatabaseCount("products", 0);
    }

    public function test_failed_to_delete_product(): void
    {

        $response = $this->deleteJson('/api/products/1');
        $response->assertInternalServerError();
    }
}
