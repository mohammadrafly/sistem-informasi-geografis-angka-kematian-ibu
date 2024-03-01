<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Daerah;
use App\Models\POI;

class HomeController extends Controller
{
    private function jsonResponse($success, $message, $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message
        ], $statusCode);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Home',
            'artikel' => Artikel::all(),
        ];
        return view('', compact('data'));
    }

    public function artikelHome()
    {
        $data = [
            'title' => 'Artikel',
            'artikel' => Artikel::all(),
        ];
        return view('', compact('data'));
    }

    public function artikelSingleHome(Request $request, $id)
    {
        $data = [
            'title' => 'Artikel',
            'artikel' => Artikel::find($id),
        ];
        return view('', compact('data'));
    }

    public function artikelCategoryHome(Request $request, $id)
    {
        $data = [
            'title' => 'Artikel',
            'artikel' => Artikel::with('category')->where('category', $id)->get(),
        ];
        return view('', compact('data'));
    }

    public function peta()
    {
        $data = [
            'title' => 'PETA Resiko',
        ];
        return view('', compact('data'));
    }
    
    public function petaResiko(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'petaResiko' => Daerah::all(),
                'petaPoint' => POI::all(),
            ]);
        }
    }
}
