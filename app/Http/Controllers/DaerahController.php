<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Daerah;

class DaerahController extends Controller
{
    private function jsonResponse(bool $success, string $message, int $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
        ], $statusCode);
    }

    public function daerah(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'title' => 'Data Daerah',
                'daerah' => Daerah::all(),
            ];
            return view('page.dashboard.daerah', compact('data'));
        }

        $daerah = Daerah::create($request->only('nama_daerah', 'warna'));

        if ($request->hasFile('geojson')) {
            $fileName = time() . '.' . $request->geojson->getClientOriginalExtension();
            $path = Storage::disk('local')->put('geojsons', $request->geojson, $fileName); // Use Storage facade
            $daerah->geojson = $path;
            $daerah->save();
        }

        return $this->jsonResponse(true, 'Berhasil Menambah Daerah.');
    }

    public function daerahSingle(Request $request, int $id)
    {
        if (!$request->ajax() || !Daerah::find($id)) {
            return $this->jsonResponse(false, 'Daerah not found.', 404);
        }

        if ($request->isMethod('get')) {
            return $this->jsonResponse(true, Daerah::find($id), 200);
        }

        $daerah = Daerah::find($id);
        $daerah->update($request->only(['nama_daerah', 'warna']));

        if ($request->hasFile('geojson')) {
            $fileName = time() . '.' . $request->geojson->getClientOriginalExtension();
            $path = Storage::disk('local')->put('geojsons', $request->geojson, $fileName); // Use Storage facade
            $daerah->geojson = $path;
        }

        $daerah->save();

        return $this->jsonResponse(true, 'Berhasil Memperbarui Daerah.');
    }

    public function daerahDelete(Request $request, int $id)
    {
        if (!$request->ajax() || !Daerah::find($id)) {
            return $this->jsonResponse(false, 'Daerah not found.', 404);
        }

        Daerah::find($id)->delete();

        return $this->jsonResponse(true, 'Berhasil Menghapus Daerah.');
    }
}