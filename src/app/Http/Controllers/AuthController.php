<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Fortify\Contracts\RegisterResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return app(RegisterResponse::class);
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {

            throw ValidationException::withMessages([
                'password' => ['ログイン情報が登録されていません'],
            ]);
        }

        return redirect()->intended('/admin');
    }
}
