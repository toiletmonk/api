<?php

namespace Tests\Feature;

use App\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_passes_when_valid_data_is_provided()
    {
        $data = [
            'email'=>'test@example.com',
            'name'=>'test',
            'password'=>'password',
            'password_confirmation'=>'password'
        ];

        $request = new RegisterRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_fails_when_invalid_data_is_provided()
    {
        $data = [
            'email'=>'test1',
            'name'=>'test',
            'password'=>'password',
            'password_confirmation'=>'password'
        ];

        $request = new RegisterRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
    }
}
