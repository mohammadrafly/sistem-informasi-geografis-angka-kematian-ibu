<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPenyebab;
use App\Models\Kasus;
use App\Models\POI;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function getKasusPerYear()
    {
        $countedData = Kasus::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as total'))
                            ->groupBy('year')
                            ->get()
                            ->pluck('total', 'year')
                            ->toArray();
    
        return response()->json($countedData);
    }
    
    public function getKasusPerKategori()
    {
        $countedData = Kasus::select('category_penyebab.nama_category', DB::raw('count(*) as total'))
                            ->join('category_penyebab', 'kasus.id_category', '=', 'category_penyebab.id')
                            ->groupBy('category_penyebab.nama_category')
                            ->get()
                            ->pluck('total', 'nama_category')
                            ->toArray();
    
        return response()->json($countedData);
    }

    public function kasus(Request $request)
    {
        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                $perPage = $request->input('per_page', 10);
                $query = Kasus::query();
    
                $query->leftJoin('category_penyebab', 'kasus.id_category', '=', 'category_penyebab.id');
                $query->leftJoin('poi', 'kasus.alur', '=', 'poi.id');
          
                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('kasus.alamat', 'like', "%$searchTerm%")
                          ->orWhere('kasus.nama', 'like', "%$searchTerm%")
                          ->orWhere('kasus.usia_ibu', 'like', "%$searchTerm%")
                          ->orWhere('kasus.tanggal', 'like', "%$searchTerm%")
                          ->orWhere('kasus.tempat_kematian', 'like', "%$searchTerm%")
                          ->orWhere('kasus.estafet_rujukan', 'like', "%$searchTerm%")
                          ->orWhere('kasus.alur', 'like', "%$searchTerm%")
                          ->orWhere('category_penyebab.nama_category', 'like', "%$searchTerm%")
                          ->orWhere('kasus.masa_kematian', 'like', "%$searchTerm%")
                          ->orWhere('kasus.hari_kematian', 'like', "%$searchTerm%")
                          ->orWhere('kasus.bukti_kematian', 'like', "%$searchTerm%");
                }

                $alurValues = Kasus::pluck('alur')->toArray();
                
                foreach ($alurValues as $alurValue) {
                    $query->orWhere('kasus.alur', 'like', "%$alurValue%");
                }
    
                $data = $query->select(
                                    'kasus.*', 
                                    'kasus.id as id', 
                                    'category_penyebab.nama_category as nama_kategori',
                                    'poi.nama_titik as nama_titik',
                                    'poi.id as id_poi'
                                )
                              ->paginate($perPage); 
                return $this->jsonResponse(true, $data, 200);
            }

            $bukti_kematian = $this->handleFileUpload($request);
            $alur = implode(',', $request->alur);

            $data = Kasus::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'usia_ibu' => $request->usia_ibu,
                'tanggal' => $request->tanggal,
                'id_category' => $request->id_category,
                'bukti_kematian' => $bukti_kematian,
                'tempat_kematian' => $request->tempat_kematian,
                'estafet_rujukan' => $request->estafet_rujukan,
                'alur' => $alur,
                'masa_kematian' => $request->masa_kematian,
                'hari_kematian' => $request->hari_kematian,
            ]);

            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'message' => 'New data added: ' . $data->nama,
                ]);
            }

            return $this->jsonResponse(true, 'Berhasil Menambah Kasus.');
        }

        $data = [
            'title' => 'Data Kasus',
            'penyebab' => CategoryPenyebab::all(),
            'poi' => POI::with('category')->where('id_category', '2')->get(),
        ];
        return view('page.dashboard.kasus', compact('data'));
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
            $kasus->update($request->only(['nama', 'alamat', 'usia_ibu', 'tanggal', 'id_category', 'tempat_kematian', 'estafet_rujukan', 'alur', 'masa_kematian', 'hari_kematian']));
    
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
            $kasus = Kasus::find($id);
            $kasus->delete();
            return $this->jsonResponse(true, 'Berhasil Menghapus Kasus.');
        }
    }

    public function kasusCategory(Request $request)
    {
        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                $perPage = $request->input('per_page', 10);
                $query = CategoryPenyebab::query();
    
                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $query->where('nama_category', 'like', "%$searchTerm%");
                }
    
                $categories = $query->paginate($perPage);
    
                return $this->jsonResponse(true, $categories, 200);
            }
    
            CategoryPenyebab::create([
                'nama_category' => $request->nama_category,
            ]);
    
            return $this->jsonResponse(true, 'Berhasil Menambah Kategori Penyebab.');
        }

        $data = [
            'title' => 'Data Category Penyebab Kasus',
        ];
        return view('page.dashboard.kasusCategory', compact('data'));
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
            $CategoryPenyebab = CategoryPenyebab::find($id);
            $CategoryPenyebab->delete();

            return $this->jsonResponse(true, 'Berhasil Menghapus category penyebab.');
        }
    }
}
