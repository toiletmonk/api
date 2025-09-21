<?php

namespace Tests\Feature;

use App\Models\File;
use App\UploadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UploadService $uploadService;

    public function setUp(): void
    {
        parent::setUp();
        $this->uploadService = new UploadService();
    }

    public function testUploadFile()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('image.jpg');
        $savedFile = $this->uploadService->uploadFile($file);

        Storage::disk('public')->assertExists($savedFile->filepath);

        $this->assertDatabaseHas('files', [
            'filename' => 'image.jpg',
            'filetype' => 'image/jpeg',
            'filepath' => $savedFile->filepath
        ]);

        $this->assertInstanceOf(File::class , $savedFile);
    }

    public function testDeleteFile()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('image.jpg');

        $savedFile = $this->uploadService->uploadFile($file);

        Storage::disk('public')->assertExists($savedFile->filepath);

        $result = $this->uploadService->deleteFile($savedFile);

        Storage::disk('public')->assertMissing($savedFile->filepath);

        $this->assertDatabaseMissing('files', [
            'filename' => 'image.jpg',
        ]);

        $this->assertTrue($result);
    }
}
