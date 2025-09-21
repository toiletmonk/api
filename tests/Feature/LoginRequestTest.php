<?php

namespace Tests\Feature;

use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_passes_with_valid_data()
    {
        $data = [
            'email'=>'test@example.com',
            'password'=>'password'
        ];

        $request = new LoginRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());

    }

    public function test_fails_without_required_data()
    {
        $data = [
            'email'=>'test',
            'password'=>'3134'
        ];

        $request = new LoginRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
    }
}
