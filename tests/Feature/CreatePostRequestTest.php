<?php

namespace Tests\Feature;

use App\Http\Requests\CreatePostRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreatePostRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_passes_with_valid_date()
    {
        $data = [
            'title'=>'Test',
            'content'=>'example'
        ];

        $request = new CreatePostRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_fails_with_missing_fields()
    {
        $data = [
            'title'=>'Test',
            'content'=>''
        ];

        $request = new CreatePostRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }
}
