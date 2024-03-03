<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\CategoryArtikel;
use App\Models\Daerah;
use App\Models\POI;

class HomeController extends Controller
{    
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
