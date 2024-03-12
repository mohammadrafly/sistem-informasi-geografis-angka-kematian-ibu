<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
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
                
                $query->leftJoin('users', 'artikel.author', '=', 'users.id');
                
                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('artikel.title', 'like', "%$searchTerm%")
                          ->orWhere('users.name', 'like', "%$searchTerm%")
                          ->orWhere('artikel.description', 'like', "%$searchTerm%")
                          ->orWhere('artikel.published', 'like', "%$searchTerm%");
                }
            
                $data = $query->select('artikel.*', 'users.name as author_name')
                              ->paginate($perPage);
            
                return $this->jsonResponse(true, $data, 200);
            }
    
            $img = $this->handleFileUpload($request);

            Artikel::create([
                'title' => $request->title,
                'author' => Auth::user()->id,
                'img' => $img,
                'description' => $request->description,
                'published' => $request->published,
            ]);

            return $this->jsonResponse(true, 'Berhasil Menambah Artikel.');
        }

        $data = [
            'title' => 'Data Artikel',
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
            $artikel->update($request->only(['title', 'author', 'description', 'published']));
    
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
}
