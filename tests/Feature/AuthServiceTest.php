<?php

namespace Tests\Feature;

use App\AuthService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;

    public function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    public function testRegisterUser()
    {
        $data = [
            'email'=>'test@example.com',
            'name'=>'Test User',
            'password'=>'password'
        ];

        $user = $this->authService->register($data);

        $this->assertDatabaseHas('users', [
            'email'=>'test@example.com',
            'name'=>'Test User'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function testLoginUser()
    {
        $user = User::factory()->create([
            'email'=>'test@example.com',
            'password'=>Hash::make('password')
        ]);

        $token = $this->authService->login([
            'email'=>'test@example.com',
            'password'=>'password'
        ]);

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }
}
