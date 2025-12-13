<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
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
