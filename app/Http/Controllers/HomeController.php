<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\CategoryArtikel;
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
        return view('page.home.index', compact('data'));
    }

    public function artikelHome()
    {
        $data = [
            'title' => 'Artikel',
            'artikel' => Artikel::all(),
            'category' => CategoryArtikel::all(),
        ];
        return view('page.home.artikel', compact('data'));
    }

    public function artikelSingleHome(Request $request, $id)
    {
        $data = [
            'title' => 'Artikel',
            'artikel' => Artikel::with('user', 'category')->find($id),
        ];
        return view('page.home.artikelSingle', compact('data'));
    }

    public function artikelCategoryHome(Request $request, $id)
    {
        $data = [
            'title' => CategoryArtikel::find($id)->nama_category,
            'artikel' => Artikel::with('user', 'category')->where('id_category', $id)->get(),
        ];
        return view('page.home.artikelCategory', compact('data'));
    }

    public function peta()
    {
        $data = [
            'title' => 'PETA Resiko',
        ];
        return view('page.home.peta', compact('data'));
    }
    
    public function getPOI()
    {
        $data = POI::all();
        return $this->jsonResponse(true, $data, 200);
    }

    public function getDaerah()
    {
        $data = Daerah::all();
        return $this->jsonResponse(true, $data, 200);
    }
}
