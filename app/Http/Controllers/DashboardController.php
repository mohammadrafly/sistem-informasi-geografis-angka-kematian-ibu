<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kasus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    private function jsonResponse($success, $message, $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message
        ], $statusCode);
    }
    
    public function index(Request $request)
    {
        $data = [
            'title' => 'Dashboard',
            'artikel' => Artikel::count(),
            'kasus' => Kasus::count(),
            'pengguna' => User::count(),
        ];
        return view('page.dashboard.index', compact('data'));
    }

    public function updateProfile(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!User::find($id)) {
                return $this->jsonResponse(false, 'User not found.', 404);
            }
    
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, User::find($id), 200);
            }
    
            $user = User::find($id);
            $user->update($request->only(['name', 'email']));

            return $this->jsonResponse(true, 'Berhasil Memperbarui User.', 200);
        }

        $data = [
            'title' => 'Update Profile'
        ];
        return view('page.dashboard.profile', compact('data'));
    }

    public function updatePassword(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = User::find($id);
    
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $currentPassword = $request->input('old_password');
            $newPassword = $request->input('new_password');
    
            if (Hash::check($currentPassword, $user->password)) {
                $user->password = bcrypt($newPassword);
                $user->save();
    
                return response()->json([
                    'success' => true,
                    'message' => 'Password changed successfully'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Current password is incorrect'
                ], 400);
            }
        }
    }
}
