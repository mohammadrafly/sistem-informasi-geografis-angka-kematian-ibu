<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\CategoryArtikel;

class ArtikelController extends Controller
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
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $fileName = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('imgs'), $fileName);
            return $fileName;
        }
        return null;
    }

    public function artikel(Request $request)
    {
        if ($request->ajax()) {

            $img = $this->handleFileUpload($request);

            Artikel::create([
                'title' => $request->title,
                'author' => $request->author,
                'img' => $img,
                'description' => $request->description,
                'category' => $request->category,
                'published' => $request->published,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah Artikel.');
        }

        $data = [
            'title' => 'Data Artikel',
            'artikel' => Artikel::all(),
        ];
        return view('page.dashboard.artikel', compact('data'));
    }

    public function artikelSingle(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!Artikel::find($id)) {
                return $this->jsonResponse(false, 'Artikel not found.', 404);
            }
    
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, Artikel::find($id), 200);
            }
    
            $artikel = Artikel::find($id);
            $artikel->update($request->only(['title', 'author', 'description', 'category', 'published']));
    
            $img = $this->handleFileUpload($request);
            if ($img) {
                $artikel->img = $img;
                $artikel->save();
            }

            return $this->jsonResponse(true, 'Berhasil Memperbarui Artikel.');
        }
    }

    public function artikelDelete(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!Artikel::find($id)) {
                return $this->jsonResponse(false, 'Artikel not found.', 404);
            }

            $artikel = Artikel::find($id);
            $artikel->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus Artikel.');
        }
    }

    public function artikelCategory(Request $request)
    {
        if ($request->ajax()) {
            CategoryArtikel::create([
                'nama_category' => $request->nama_category,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah CategoryArtikel.');
        }

        $data = [
            'title' => 'Data CategoryArtikel',
            'categoryArtikel' => CategoryArtikel::all(),
        ];
        return view('page.dashboard.artikelCategory', compact('data'));
    }

    public function artikelCategorySingle(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!CategoryArtikel::find($id)) {
                return $this->jsonResponse(false, 'Category Artikel not found.', 404);
            }
    
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, CategoryArtikel::find($id), 200);
            }
    
            $categoryArtikel = CategoryArtikel::find($id);
            $categoryArtikel->update($request->only(['nama_category']));
    
            return $this->jsonResponse(true, 'Berhasil Memperbarui Category Artikel.');
        }
    }

    public function artikelCategoryDelete(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!CategoryArtikel::find($id)) {
                return $this->jsonResponse(false, 'Category Artikel not found.', 404);
            }

            if (!Artikel::find('category', $id)) {
                return $this->jsonResponse(false, 'Cannot delete the category. It is being used by articles.', 400);
            }

            $CategoryArtikel = CategoryArtikel::find($id);
            $CategoryArtikel->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus Category Artikel.');
        }
    }
}
