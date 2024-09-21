<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\Tps;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class KelurahanController extends Controller
{
    public function index(Request $request)
    {
        // Get search inputs
        $searchKecamatan = $request->input('search_kecamatan');
        $searchKelurahan = $request->input('search_kelurahan');
        // Fetch all kecamatan with pagination
        $kecamatansQuery = Kecamatan::query();
        if ($searchKecamatan) {
            $kecamatansQuery->where('nama_kecamatan', 'like', "%{$searchKecamatan}%");
        }
        $kecamatans = $kecamatansQuery->paginate(40)
            ->appends(['search_kecamatan' => $searchKecamatan]);
        // Fetch all kelurahan related to the current paginated kecamatan
        $kelurahans = Kelurahan::with('kecamatan')->whereIn('kecamatan_id', $kecamatans->pluck('kecamatan_id'))
            ->when($searchKelurahan, function ($query) use ($searchKelurahan) {
                $query->where('nama_kelurahan', 'like', "%{$searchKelurahan}%");
            })
            ->get()
            ->groupBy('kecamatan_id');
        // Pass both kecamatans and kelurahans to the view
        return view('admin.kelurahan.index', compact('kecamatans', 'kelurahans', 'searchKecamatan', 'searchKelurahan'));
    }



    public function create()
    {
        $kecamatan = Kecamatan::all();
        return view('admin.kelurahan.create', compact('kecamatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelurahan' => 'required|string|max:1000|unique:kelurahans',
            'kecamatan_id' => 'required|exists:kecamatan,kecamatan_id',
        ]);

        Kelurahan::create([
            'kelurahan_id' => (string) Str::uuid(),
            'nama_kelurahan' => $request->input('nama_kelurahan'),
            'kecamatan_id' => $request->input('kecamatan_id'),
        ]);

        return redirect()->route('kelurahan.index')->with('status', 'Kelurahan created successfully!');
    }

    public function show(Kelurahan $kelurahan)
    {
        return view('admin.kelurahan.show', compact('kelurahan'));
    }

    public function edit(Kelurahan $kelurahan)
    {
        $kecamatan = Kecamatan::all();
        return view('admin.kelurahan.edit', compact('kelurahan', 'kecamatan'));
    }

    public function update(Request $request, Kelurahan $kelurahan)
    {
        $request->validate([
            'nama_kelurahan' => 'required|string|max:1000',
            'kecamatan_id' => 'required|exists:kecamatan,kecamatan_id',
        ]);

        $kelurahan->update([
            'nama_kelurahan' => $request->input('nama_kelurahan'),
            'kecamatan_id' => $request->input('kecamatan_id'),
        ]);

        return redirect()->route('kelurahan.index')->with('status', 'Kelurahan updated successfully.');
    }

    public function destroy(Kelurahan $kelurahan)
    {
        // Hapus data TPS yang terkait dengan kelurahan
        Tps::where('kelurahan_id', $kelurahan->kelurahan_id)->delete();

        // Setelah menghapus TPS, hapus Kelurahan
        $kelurahan->delete();
        return redirect()->route('kelurahan.index')->with('status', 'Kelurahan and related TPS deleted successfully.');
    }
}
