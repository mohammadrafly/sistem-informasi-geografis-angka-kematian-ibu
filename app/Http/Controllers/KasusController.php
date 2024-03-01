<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPenyebab;
use App\Models\Kasus;
use App\Models\POI;

class KasusController extends Controller
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
        if ($request->hasFile('bukti_kematian')) {
            $bukti_kematian = $request->file('bukti_kematian');
            $fileName = time() . '.' . $bukti_kematian->getClientOriginalExtension();
            $bukti_kematian->move(public_path('bukti_kematians'), $fileName);
            return $fileName;
        }
        return null;
    }

    public function kasus(Request $request)
    {
        if ($request->ajax()) {

            $bukti_kematian = $this->handleFileUpload($request);

            Kasus::create([
                'alamat' => $request->alamat,
                'usia_ibu' => $request->usia_ibu,
                'tanggal' => $request->tanggal,
                'id_category' => $request->id_category,
                'bukti_kematian' => $bukti_kematian,
                'tempat_kematian' => $request->tempat_kematian,
                'estafet_rujukan' => $request->estafet_rujukan,
                'alur' => $request->alur,
                'masa_kematian' => $request->masa_kematian,
                'hari_kematian' => $request->hari_kematian,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah Kasus.');
        }

        $data = [
            'title' => 'Data Kasus',
            'kasus' => Kasus::all(),
        ];
        return view('', compact('data'));
    }

    public function kasusSingle(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!Kasus::find($id)) {
                return $this->jsonResponse(false, 'Kasus not found.', 404);
            }
    
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, Kasus::find($id), 200);
            }
    
            $kasus = Kasus::find($id);
            $kasus->update($request->only(['alamat', 'usia_ibu', 'tanggal', 'id_category', 'tempat_kematian', 'estafet_rujukan', 'alur', 'masa_kematian', 'hari_kematian']));
    
            $bukti_kematian = $this->handleFileUpload($request);
            if ($bukti_kematian) {
                $kasus->bukti_kematian = $bukti_kematian;
                $kasus->save();
            }

            return $this->jsonResponse(true, 'Berhasil Memperbarui Kasus.');
        }
    }

    public function kasusDelete(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!Kasus::find($id)) {
                return $this->jsonResponse(false, 'Kasus not found.', 404);
            }

            $kasus = Kasus::find($id);
            $kasus->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus Kasus.');
        }
    }

    public function kasusCategory(Request $request)
    {
        if ($request->ajax()) {
            CategoryPenyebab::create([
                'nama_category' => $request->nama_category,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah Category Penyebab.');
        }

        $data = [
            'title' => 'Data Category Penyebab',
            'category Penyebab' => CategoryPenyebab::all(),
        ];
        return view('', compact('data'));
    }

    public function kasusCategorySingle(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!CategoryPenyebab::find($id)) {
                return $this->jsonResponse(false, 'Category Penyebab not found.', 404);
            }
    
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, CategoryPenyebab::find($id), 200);
            }
    
            $categoryPenyebab = CategoryPenyebab::find($id);
            $categoryPenyebab->update($request->only(['nama_category']));
    
            return $this->jsonResponse(true, 'Berhasil Memperbarui category penyebab.');
        }
    }

    public function kasusCategoryDelete(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!CategoryPenyebab::find($id)) {
                return $this->jsonResponse(false, 'category penyebab not found.', 404);
            }

            if (!Kasus::find('category', $id)) {
                return $this->jsonResponse(false, 'Cannot delete the category. It is being used by articles.', 400);
            }

            $CategoryPenyebab = CategoryPenyebab::find($id);
            $CategoryPenyebab->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus category penyebab.');
        }
    }
}
