<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_are_listed_correctly_(): void
    {
        File::factory()->count(3)->create();
        Category::factory()->count(3)->create();

        $this->assertDatabaseCount('categories', 3);

        $response = $this->get('/api/categories');
        $response->assertOk();
    }

    public function test_category_is_stored_correctly_in_database()
    {
        File::factory()->count(1)->create();

        $fileContent = 'Simulated file content for testing';
        $base64File = 'data:image/png;base64,' . base64_encode($fileContent);

        $payload = [
            'image' => $base64File,
            'category' => 'Test Category',
            'status' => 1,
            'description' => 'Test Description',
        ];

        $response = $this->postJson('/api/categories', $payload);
        $response->assertStatus(201);

        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'status' => 1,
            'description' => 'Test Description',
        ]);
    }
}
