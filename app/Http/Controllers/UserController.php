<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    private function jsonResponse($success, $message, $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
        ], $statusCode);
    }

    public function index(Request $request) 
    {
        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                $perPage = $request->input('per_page', 10);
                $query = User::query();
    
                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('name', 'like', "%$searchTerm%");
                    $query->orWhere('email', 'like', "%$searchTerm%");
                    $query->orWhere('role', 'like', "%$searchTerm%");
                }
    
                $data = $query->paginate($perPage);
    
                return $this->jsonResponse(true, $data, 200);
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), 
                'role' => $request->role,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah User.');
        }
        
        $data = [
            'title' => 'Data Pengguna',
        ];
        return view('page.dashboard.user', compact('data'));
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!User::find($id)) {
                return $this->jsonResponse(false, 'User not found.', 404);
            }
    
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, User::find($id), 200);
            }
    
            $user = User::find($id);
            $user->update($request->only(['name', 'email', 'role']));

            return $this->jsonResponse(true, 'Berhasil Memperbarui User.');
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = User::find($id);
            $user->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus category penyebab.');
        }
    }
}