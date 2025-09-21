<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PostService $postService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postService = new PostService();
    }

    public function test_returns_paginated_posts_filtered_by_category()
    {
        $category = Category::factory()->create();
        $category1 = Category::factory()->create();

        Post::factory()->count(3)->create(['category_id' => $category->id]);
        Post::factory()->count(2)->create(['category_id' => $category1->id]);

        $result = $this->postService->getFilteredPosts(['category_id' => $category->id]);

        $this->assertEquals(3, $result->total());
        $this->assertCount(3, $result->items());
    }

    public function test_returns_paginated_posts_filtered_by_search()
    {
        Post::factory()->count(3)->create(['title' => 'test']);

        $result = $this->postService->getFilteredPosts(['search' => 'test']);

        $this->assertEquals(3, $result->total());
        $this->assertCount(3, $result->items());

        foreach ($result->items() as $post) {
            $this->assertStringContainsString('test', $post->title);
        }
    }

    public function test_returns_paginated_posts_with_limit_of_10_per_page()
    {
        Post::factory()->count(15)->create(['title' => 'test']);

        $result = $this->postService->getFilteredPosts(['limit' => 10]);

        $this->assertEquals(15, $result->total());
        $this->assertCount(10, $result->items());

        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(1, $result->currentPage());
    }
}
