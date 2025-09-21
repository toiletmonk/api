<?php

namespace Tests\Feature;

use App\AuthService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;
    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    public function test_fails_when_invalid_data_is_provided()
    {
        $data = [
            'email' => 'invalid_email',
            'password' => 'invalid_password',
        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(422);
    }

    public function test_passes_when_valid_data_is_provided()
    {
        $data = [
            'email' => 'test@example.com',
            'name'=>'test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(200);
    }

    public function test_login_fails_when_invalid_data_is_provided()
    {
        $data = [
            'email'=>'test.com',
            'password' => 'asdasd',
        ];

        $response = $this->postJson('/api/login', $data);
        $response->assertStatus(422);
    }

    public function test_login_passes_when_valid_data_is_provided()
    {
        User::factory()->create([
            'email'=>'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $data = [
            'email'=>'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $data);
        $response->assertStatus(200);
    }
}
