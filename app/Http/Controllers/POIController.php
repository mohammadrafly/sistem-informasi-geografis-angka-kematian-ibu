<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\POI;
use App\Models\CategoryPOI;
use App\Models\Daerah;
use App\Models\Kasus;

class POIController extends Controller
{
    private function jsonResponse($success, $message, $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message
        ], $statusCode);
    }

    private function handleFileUpload(Request $request)
    {
        if ($request->hasFile('geojson')) {
            $geojson = $request->file('geojson');

            $content = file_get_contents($geojson->getPathname());

            $data = json_decode($content, true);

            $coordinates = [];
            foreach ($data['features'] as $feature) {
                if (isset($feature['geometry']['coordinates'])) {
                    $coordinates = array_merge($coordinates, $feature['geometry']['coordinates']);
                }
            }

            $jsContent = json_encode($coordinates, JSON_PRETTY_PRINT);

            return $jsContent;
        }
        return null;
    }

    public function getPOI()
    {
        $data = POI::with('kasus', 'category', 'penyebab')->get();
        return response()->json($data);
    }

    public function poi(Request $request)
    {
        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                $perPage = $request->input('per_page', 10);
                $query = POI::query();

                $query->leftJoin('kasus', 'poi.id_kasus', '=', 'kasus.id')
                      ->leftJoin('category_poi', 'poi.id_category', '=', 'category_poi.id');

                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('poi.nama_titik', 'like', "%$searchTerm%")
                            ->orWhere('kasus.alamat', 'like', "%$searchTerm%")
                            ->orWhere('poi.geojson', 'like', "%$searchTerm%")
                            ->orWhere('category_poi.nama_category', 'like', "%$searchTerm%")
                            ->orWhere('poi.warna', 'like', "%$searchTerm%");
                }

                $data = $query->select('poi.*', 'kasus.nama as nama', 'category_poi.nama_category as nama_kategori')
                                ->paginate($perPage);

                return $this->jsonResponse(true, $data, 200);
            }

            $geojson = $this->handleFileUpload($request);

            $poi = POI::create([
                'nama_titik' => $request->nama_titik,
                'geojson' => $geojson,
                'warna' => $request->warna,
                'daerah_id' => $request->id_daerah,
                'id_category' => $request->id_category,
                'id_kasus' => $request->id_kasus,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah Point Of Interest.');
        }

        $existingIds = POI::whereNotNull('id_kasus')->pluck('id_kasus')->toArray();

        $data = [
            'title' => 'Data Point Of Interest',
            'category' => CategoryPOI::all(),
            'kasus' => empty($existingIds) ? Kasus::all() : Kasus::whereNotIn('id', $existingIds)->get(),
            'daerah' => Daerah::all(),
            'poi' => POI::with('kasus', 'category', 'daerah')->get(),
        ];

        return view('page.dashboard.poi', compact('data'));
    }

    public function poiSingle(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!POI::find($id)) {
                return $this->jsonResponse(false, 'Poi not found.', 404);
            }

            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, POI::with('kasus', 'category', 'daerah')->find($id), 200);
            }

            $poi = POI::find($id);
            $poi->update($request->only(['nama_titik', 'warna', 'id_kasus', 'id_category', 'daerah_id']));

            $geojson = $this->handleFileUpload($request);
            if ($geojson) {
                $poi->geojson = $geojson;
                $poi->save();
            }

            return $this->jsonResponse(true, 'Berhasil Memperbarui Daerah.');
        }
    }

    public function poiDelete(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!POI::find($id)) {
                return $this->jsonResponse(false, 'Poi not found.', 404);
            }

            $poi = POI::find($id);
            $poi->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus Poi.');
        }
    }

    public function poiCategory(Request $request)
    {
        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                $perPage = $request->input('per_page', 10);
                $query = CategoryPOI::query();

                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('nama_category', 'like', "%$searchTerm%");
                }

                $categories = $query->paginate($perPage);

                return $this->jsonResponse(true, $categories, 200);
            }

            CategoryPOI::create([
                'nama_category' => $request->nama_category,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah Kategori Point Of Interest.');
        }

        $data = [
            'title' => 'Data Category Point Of Interest',
        ];
        return view('page.dashboard.poiCategory', compact('data'));
    }

    public function poiCategorySingle(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!CategoryPOI::find($id)) {
                return $this->jsonResponse(false, 'Category poi not found.', 404);
            }

            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, CategoryPOI::find($id), 200);
            }

            $categorypoi = CategoryPOI::find($id);
            $categorypoi->update($request->only(['nama_category']));

            return $this->jsonResponse(true, 'Berhasil Memperbarui Category poi.');
        }
    }

    public function poiCategoryDelete(Request $request, $id)
    {
        if ($request->ajax()) {
            $CategoryPOI = CategoryPOI::find($id);
            $CategoryPOI->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus Category POI.');
        }
    }
}
