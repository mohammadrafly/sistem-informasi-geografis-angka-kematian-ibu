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
            $data = [
                'title' => 'Login'
            ];
            return view('page.auth.login', compact('data'));
        }

        if (!Auth::attempt($credentials)) {
            return $this->jsonResponse(false, 'Invalid credentials');
        }

        return $this->jsonResponse(true, 'Berhasil Login!', 204);
    }

    public function logout()
    {
        Auth::logout();

        return $this->jsonResponse(true, 'Logout successful', 200);
    }
}
