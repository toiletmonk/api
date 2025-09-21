<?php

namespace App\Http\Controllers;

use App\AuthService;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        event(new Registered($user));

        return response()->json(['message'=>'User created successfully',
        'user'=>$user]);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        return response()->json([
            'message'=>'Logged in successfully',
            'user'=>$token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message'=>'Logged out successfully']);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->authService->changePassword(Auth::user(), $request->validated());

        return response()->json(['message'=>'Password changed successfully']);
    }
}
