<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\CategoryArtikel;
use Illuminate\Support\Facades\Auth;

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
            if ($request->isMethod('get')) {
                $perPage = $request->input('per_page', 10);
                $query = Artikel::query();
                
                $query->leftJoin('users', 'artikel.author', '=', 'users.id')
                      ->leftJoin('category_artikel', 'artikel.id_category', '=', 'category_artikel.id');
                
                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('artikel.title', 'like', "%$searchTerm%")
                          ->orWhere('users.name', 'like', "%$searchTerm%")
                          ->orWhere('artikel.description', 'like', "%$searchTerm%")
                          ->orWhere('category_artikel.nama_category', 'like', "%$searchTerm%")
                          ->orWhere('artikel.published', 'like', "%$searchTerm%");
                }
            
                $data = $query->select('artikel.*', 'users.name as author_name', 'category_artikel.nama_category as category_name')
                              ->paginate($perPage);
            
                return $this->jsonResponse(true, $data, 200);
            }
    
            $img = $this->handleFileUpload($request);

            Artikel::create([
                'title' => $request->title,
                'author' => Auth::user()->id,
                'img' => $img,
                'description' => $request->description,
                'id_category' => $request->id_category,
                'published' => $request->published,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah Artikel.');
        }

        $data = [
            'title' => 'Data Artikel',
            'category' => CategoryArtikel::all(),
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
            $artikel->update($request->only(['title', 'author', 'description', 'id_category', 'published']));
    
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
            $artikel = Artikel::find($id);
            $artikel->delete();
            return $this->jsonResponse(true, 'Berhasil Menghapus Artikel.');
        }
    }

    public function artikelCategory(Request $request)
    {
        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                $perPage = $request->input('per_page', 10);
                $query = CategoryArtikel::query();
    
                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('nama_category', 'like', "%$searchTerm%");
                }
    
                $categories = $query->paginate($perPage);
    
                return $this->jsonResponse(true, $categories, 200);
            }
    
            CategoryArtikel::create([
                'nama_category' => $request->nama_category,
            ]);
    
            return $this->jsonResponse(true, 'Berhasil Menambah Kategori Artikel.');
        }
    
        $data = [
            'title' => 'Data Kategori Artikel',
        ];
        return view('page.dashboard.artikelCategory', compact('data'));
    }

    public function artikelCategorySingle(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!CategoryArtikel::find($id)) {
                return $this->jsonResponse(false, 'Kategori Artikel not found.', 404);
            }
    
            if ($request->isMethod('get')) {
                return $this->jsonResponse(true, CategoryArtikel::find($id), 200);
            }
    
            $categoryArtikel = CategoryArtikel::find($id);
            $categoryArtikel->update($request->only(['nama_category']));
    
            return $this->jsonResponse(true, 'Berhasil Memperbarui Kategori Artikel.');
        }
    }

    public function artikelCategoryDelete(Request $request, $id)
    {
        if ($request->ajax()) {
            $CategoryArtikel = CategoryArtikel::find($id);
            $CategoryArtikel->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus Kategori Artikel.');
        }
    }
}
