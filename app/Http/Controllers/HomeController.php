<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Daerah;
use App\Models\POI;
use App\Models\Kasus;
use Carbon\Carbon;

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
            'artikel' => Artikel::where('category', 'artikel')->get(),
            'informasi' => Artikel::where('category', 'informasi')->get(),
        ];

        return view('page.home.artikel', compact('data'));
    }

    public function artikelSingleHome(Request $request, $id)
    {
        $data = [
            'title' => 'Artikel',
            'artikel' => Artikel::with('user')->find($id),
        ];
        return view('page.home.artikelSingle', compact('data'));
    }

    public function peta(Request $request)
    {
        $data = [
            'title' => 'PETA Resiko',
        ];

        return view('page.home.peta', compact('data'));
    }

    public function getJumlahKasus(Request $request)
    {
        $kasus = Kasus::with('category')->get();

        if ($request->ajax()) {
            if ($request->has('year')) {
                $year = $request->input('year');
                $kasus = $kasus->filter(function ($kasus) use ($year) {
                    return Carbon::parse($kasus->tanggal)->format('Y') == $year;
                });
            }

            $groupedData = [
                'groupPenyebab' => $kasus->groupBy('category.nama_category')->map(function ($group) {
                    return $group->count();
                }),
                'groupTempat' => $kasus->groupBy('tempat_kematian')->map(function ($group) {
                    return $group->count();
                }),
            ];

            return $this->jsonResponse(true, $groupedData, 200);
        }
    }

    public function getPOI()
    {
        $data = POI::with('kasus', 'category', 'penyebab')->get();
        return response()->json($data);
    }

    public function getDaerah()
    {
        $data = Daerah::with('poi')->get();

        return response()->json($data);
    }
}
