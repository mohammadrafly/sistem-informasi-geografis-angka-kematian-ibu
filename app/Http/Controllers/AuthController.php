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
        $credentials = $request->only('email', 'password');

        if (!$request->ajax()) {
            return view('auth.login', compact(['title' => 'Login']));
        }

        if (!Auth::attempt($credentials)) {
            return $this->jsonResponse(false, 'Invalid credentials');
        }

        return $this->jsonResponse(true, '', 204);
    }

    public function logout()
    {
        Auth::logout();

        return $this->jsonResponse(true, 'Logout successful', 200);
    }
}
