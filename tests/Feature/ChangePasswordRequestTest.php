<?php

namespace Tests\Feature;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ChangePasswordRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_passes_when_valid_data_is_provided()
    {
        $data = [
            'current_password'=>'password',
            'new_password'=>'password123',
            'new_password_confirmation'=>'password123'
        ];

        $request = new ChangePasswordRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_fails_when_valid_data_is_not_provided()
    {
        $data = [
            'current_password'=>'password',
            'new_password'=>'password123',
        ];

        $request = new ChangePasswordRequest();

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
    }
    
}
