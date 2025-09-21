<?php

namespace Tests\Feature;

use App\Http\Requests\UploadRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UploadRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_passes_when_valid_data_is_provided()
    {
        $fakeFile = UploadedFile::fake()->create('document.pdf', 2000);
        $data = ['file'=>$fakeFile];

        $request = new UploadRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_fails_when_invalid_data_is_provided()
    {
        $fakeFile = UploadedFile::fake()->create('document.txt', 3000);

        $data = [
            'file'=>$fakeFile];

        $request = new UploadRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
    }

    public function test_fails_when_no_data_is_provided()
    {
        $data = [];

        $request = new UploadRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
    }
}
