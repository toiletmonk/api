<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_fails_when_invalid_data_is_provided()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $data = [
            'file'=>'sound.mp3'
        ];

        $response = $this->postJson('/api/upload', $data);
        $response->assertStatus(422);
    }

    public function test_passes_when_valid_data_is_provided()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $file = UploadedFile::fake()->image('image.jpg')->size(100);

        $response = $this->postJson('/api/upload', ['file' => $file]);
        $response->assertStatus(200);
    }
}
