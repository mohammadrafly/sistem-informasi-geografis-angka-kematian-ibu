<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\POI;
use App\Models\CategoryPOI;

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
            $fileName = time() . '.' . $geojson->getClientOriginalExtension();
            $geojson->move(public_path('geojsons'), $fileName);
            return $fileName;
        }
        return null;
    }
    
    public function poi(Request $request)
    {
        if ($request->ajax()) {
            
            $geojson = $this->handleFileUpload($request);

            POI::create([
                'nama_titik' => $request->nama_titik,
                'geojson' => $geojson,
                'warna' => $request->warna,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah POI.');
        }

        $data = [
            'title' => 'Data Point Of Interest',
            'poi' => POI::all(),
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
                return $this->jsonResponse(true, POI::find($id), 200);
            }
    
            $poi = POI::find($id);
            $poi->update($request->only(['nama_titik', 'warna']));
    
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
            CategoryPOI::create([
                'nama_category' => $request->nama_category,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah CategoryPOI.');
        }

        $data = [
            'title' => 'Data Category Point Of Interest',
            'categoryPOI' => CategoryPOI::all(),
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
            if (!CategoryPOI::find($id)) {
                return $this->jsonResponse(false, 'Category Artikel not found.', 404);
            }

            if (!POI::find('category', $id)) {
                return $this->jsonResponse(false, 'Cannot delete the category. It is being used by POI.', 400);
            }

            $CategoryPOI = CategoryPOI::find($id);
            $CategoryPOI->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus Category POI.');
        }
    }
}
