<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
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
        if ($request->ajax()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), 
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah User.');
        }

        $data = [
            'title' => 'Data User',
            'users' => User::all(),
        ];
        return view('user.index', compact('data'));
    }

    public function show(Request $request, int $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->jsonResponse(false, 'User not found.', 404);
        }

        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, $user, 200);
            }

            $user->update($request->only(['name', 'email']));

            return $this->jsonResponse(true, 'Berhasil Memperbarui User.');
        }

        return view('user.show', compact('user'));
    }

    public function destroy(int $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->jsonResponse(false, 'User not found.', 404);
        }

        $user->delete();

        return $this->jsonResponse(true, 'Berhasil Menghapus User.');
    }
}