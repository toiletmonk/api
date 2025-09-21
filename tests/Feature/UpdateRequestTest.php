<?php

namespace Tests\Feature;

use App\Http\Requests\UpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_passes_when_valid_data_is_provided()
    {
        $data = [
            'title'=>'example',
            'content'=>'test'
        ];

        $request = new UpdateRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_fails_when_invalid_data_is_provided()
    {
        $data = [
            'title'=>'',
            'content'=>'test'
        ];

        $request = new UpdateRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
    }
}
