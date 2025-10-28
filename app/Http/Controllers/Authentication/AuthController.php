<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\LoginRequest;
use App\Http\Requests\Web\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\LoginRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(public LoginRepositoryInterface $login, public AuthRepositoryInterface $register)
    {
    }
    public function login()
    {
        return view('auth.web.login');
    }

    public function register()
    {
        return view('auth.web.register');
    }

    public function forgetPassword()
    {
        return view('auth.web.forget-password');
    }


    public function loginPost(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password'); // Extract credentials from request

        $response = $this->login->attemptLogin($credentials, false);
        $decoded = json_decode($response->getContent(), true);
        $success = $decoded['success'];
        $message = $decoded['message'];
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
    public function registerPost(RegisterRequest $request)
    {
        $response = $this->register->registerByEmailPassword($request->sanitized(), false);
        $decoded = json_decode($response->getContent(), true);
        $success = $decoded['success'];
        $message = $decoded['message'];
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('web.index');
    }
}
