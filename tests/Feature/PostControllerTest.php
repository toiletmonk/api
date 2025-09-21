<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_filtered_posts()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Post::factory()->count(10)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*'=> [
                'id',
                'title',
                'excerpt',
                'category_id',
            ],
           ]
        ]);
    }

    public  function test_store()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = [
            'title'=>'test title',
            'content'=>'test content',
        ];

        $response = $this->postJson('/api/posts', $data);
        $response->assertStatus(200)
                ->assertJson(['message' => 'Post created successfully']);

        $this->assertDatabaseHas('posts', $data);
    }

    public  function test_update()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $post = Post::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ];

        $response = $this->putJson("/api/posts/{$post->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Post updated successfully']);
    }

    public  function test_destroy()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing($post);
    }
}
