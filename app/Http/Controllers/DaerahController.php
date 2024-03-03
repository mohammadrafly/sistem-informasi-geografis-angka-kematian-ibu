<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Daerah;

class DaerahController extends Controller
{
    private function jsonResponse($success, $message, $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
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

    public function daerah(Request $request)
    {
        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                $perPage = $request->input('per_page', 10);
                $query = Daerah::query();

                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('nama_daerah', 'like', "%$searchTerm%")
                            ->orWhere('geojson', 'like', "%$searchTerm%")
                            ->orWhere('warna', 'like', "%$searchTerm%");
                }
            
                $data = $query->paginate($perPage);
      
                return $this->jsonResponse(true, $data, 200);
            }

            $geojson = $this->handleFileUpload($request);

            Daerah::create([
                'nama_daerah' => $request->nama_daerah,
                'geojson' => $geojson,
                'warna' => $request->warna,
            ]);
    
            return $this->jsonResponse(true, 'Berhasil Menambah Daerah.');
        }

        $data = [
            'title' => 'Data Daerah',
        ];
        return view('page.dashboard.daerah', compact('data'));
    }

    public function daerahSingle(Request $request, int $id)
    {
        if ($request->ajax()) {
            if (!$request->ajax()) {
                return $this->jsonResponse(false, 'Daerah not found.', 404);
            }
    
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, Daerah::find($id), 200);
            }
    
            $daerah = Daerah::find($id);
            $daerah->update($request->only(['nama_daerah', 'warna']));
    
            $geojson = $this->handleFileUpload($request);
    
            if ($geojson) {
                $daerah->geojson = $geojson;
                $daerah->save();
            }
    
            return $this->jsonResponse(true, 'Berhasil Memperbarui Daerah.');
        }
    }

    public function daerahDelete(Request $request, int $id)
    {
        if ($request->ajax()) {
            Daerah::find($id)->delete();
            return $this->jsonResponse(true, 'Berhasil Menghapus Daerah.');
        }
    }
}