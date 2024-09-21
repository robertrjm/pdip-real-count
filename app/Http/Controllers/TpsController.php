<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Models\Tps;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TpsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query to get TPS along with Kecamatan and Kelurahan
        $tpsQuery = Tps::join('kelurahans', 'tps.kelurahan_id', '=', 'kelurahans.kelurahan_id')
            ->join('kecamatan', 'kecamatan.kecamatan_id', '=', 'kelurahans.kecamatan_id')
            ->select('tps.*', 'kelurahans.nama_kelurahan', 'kecamatan.nama_kecamatan')
            ->distinct();

        if ($search) {
            $tpsQuery->where('kecamatan.nama_kecamatan', 'like', "%{$search}%");
        }

        // Order by nama_tps in ascending order
        $tpsQuery->orderBy('tps.nama_tps', 'asc');

        // Fetch all TPS data (no pagination)
        $tps = $tpsQuery->get();

        // Paginate Kecamatan data separately
        $kecamatanQuery = Kecamatan::query();

        if ($search) {
            $kecamatanQuery->where('nama_kecamatan', 'like', "%{$search}%");
        }

        $kecamatans = $kecamatanQuery->paginate(40);

        return view('admin.tps.index', compact('tps', 'search', 'kecamatans'));
    }







    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve all Kecamatan data
        $kecamatans = Kecamatan::all();

        // Retrieve all Kelurahan data
        $kelurahans = Kelurahan::all();

        return view('admin.tps.create', compact('kecamatans', 'kelurahans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi kustom
        $validator = Validator::make($request->all(), [
            'kelurahan_id' => 'required',
            'nama_tps' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = Tps::where('kelurahan_id', $request->kelurahan_id)
                        ->where('nama_tps', $value)
                        ->exists();

                    if ($exists) {
                        $fail('Nama TPS sudah ada di kelurahan ini.');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan TPS
        Tps::create([
            'tps_id' => (string) Str::uuid(),
            'kelurahan_id' => $request->kelurahan_id,
            'nama_tps' => $request->nama_tps,
        ]);

        return redirect()->route('tps.index')->with('status', 'TPS berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)

    {
        $tps = Tps::join('kelurahans', 'tps.kelurahan_id', '=', 'kelurahans.kelurahan_id')
            ->select('tps.*', 'kelurahans.nama_kelurahan')->findOrFail($id);
        return view('admin.tps.show', compact('tps'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tps = Tps::findOrFail($id);
        $kelurahans = Kelurahan::all();
        return view('admin.tps.edit', compact('tps', 'kelurahans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kelurahan_id' => 'required|exists:kelurahans,kelurahan_id',
            'nama_tps' => 'required|string|max:255',
        ]);

        $tps = Tps::findOrFail($id);
        $tps->update([
            'kelurahan_id' => $request->kelurahan_id,
            'nama_tps' => $request->nama_tps,
        ]);

        return redirect()->route('tps.index')->with('status', 'TPS berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tps = Tps::findOrFail($id);
        $tps->delete();
        return redirect()->route('tps.index')->with('status', 'TPS berhasil dihapus.');
    }
    public function getKelurahansByKecamatan($kecamatan_id)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        // Debugging untuk memastikan apakah ada data yang diambil
        // dd($kelurahans);
        return response()->json($kelurahans);
    }
}
