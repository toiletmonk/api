<?php

namespace App;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'email'=>$data['email'],
            'name'=>$data['name'],
            'password'=>Hash::make($data['password'])
        ]);
    }

    public function login(array $data): string
    {
        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['Invalid credentials']);
        };

        $token = $user->createToken('api-token')->plainTextToken;

        return $token;
    }

    public function changePassword(User $user, array $data): void
    {
        if(!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password'=>'Invalid current password'
            ]);
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();
    }
}
