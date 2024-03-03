<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private function jsonResponse(bool $success, string $message, int $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
        ], $statusCode);
    }

    public function index(Request $request)
    {
        $data = ['title' => 'Login'];
        return !$request->ajax('get')
        ? view('page.auth.login', compact('data'))
        : (Auth::attempt($request->only('email', 'password'))
            ? $this->jsonResponse(true, 'Berhasil Login!', 200)
            : $this->jsonResponse(false, 'Password Salah', 400));
    
    }

    public function logout()
    {
        Auth::logout();
        return $this->jsonResponse(true, 'Logout successful', 200);
    }
}
