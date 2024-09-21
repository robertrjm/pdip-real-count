<?php

namespace App\Http\Controllers;

use App\Models\Suara;
use App\Models\TPS; // Ensure you have TPS model
use App\Models\Calon;
use App\Models\Kelurahan;
use App\Models\Kecamatan; // Ensure you have Kelurahan model
// Ensure you have Kelurahan model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuaraController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query to get TPS along with Kecamatan and Kelurahan
        $tpsQuery = Tps::join('kelurahans', 'tps.kelurahan_id', '=', 'kelurahans.kelurahan_id')
            ->join('kecamatan', 'kecamatan.kecamatan_id', '=', 'kelurahans.kecamatan_id')
            ->leftJoin('suara', 'tps.tps_id', '=', 'suara.tps_id')
            ->select(
                'tps.tps_id',
                'tps.nama_tps',
                'kelurahans.nama_kelurahan',
                'kelurahans.kelurahan_id',
                'kecamatan.nama_kecamatan',
                DB::raw('COALESCE(SUM(suara.jumlah_suara), 0) as total_suara')
            )
            ->groupBy(
                'tps.tps_id',
                'tps.nama_tps',
                'kelurahans.nama_kelurahan',
                'kelurahans.kelurahan_id',
                'kecamatan.nama_kecamatan'
            );

        // Search based on Kecamatan name
        if ($search) {
            $tpsQuery->whereRaw('LOWER(kecamatan.nama_kecamatan) LIKE ?', ['%' . strtolower(trim($search)) . '%']);
        }

        // Sort TPS by name
        $tpsQuery->orderBy('tps.nama_tps', 'asc');

        // Retrieve all TPS data
        $tps = $tpsQuery->get();

        // Retrieve all candidates
        $calons = Calon::orderBy('no_urut', 'asc')->get();

        // Retrieve existing votes for each TPS and Kelurahan combination
        $suaraVotes = Suara::whereIn('tps_id', $tps->pluck('tps_id'))
            ->whereIn('kelurahan_id', $tps->pluck('kelurahan_id'))
            ->get()
            ->keyBy(function ($item) {
                return $item->tps_id . '-' . $item->kelurahan_id . '-' . $item->calon_id;
            });

        // Calculate total maximum votes
        $totalSuaraMax = Suara::sum('jumlah_suara');

        // Calculate total votes per Kelurahan and TPS status
        $kelurahanData = [];
        foreach ($tps as $item) {
            if (!isset($kelurahanData[$item->kelurahan_id])) {
                $kelurahanData[$item->kelurahan_id] = [
                    'nama_kelurahan' => $item->nama_kelurahan,
                    'total_suara' => 0,
                    'total_tps' => 0,
                    'filled_tps' => 0,
                ];
            }
            $kelurahanData[$item->kelurahan_id]['total_suara'] += $item->total_suara;
            $kelurahanData[$item->kelurahan_id]['total_tps']++;

            if ($item->total_suara > 0) {
                $kelurahanData[$item->kelurahan_id]['filled_tps']++;
            }
        }

        // Determine Kelurahan percentages
        foreach ($kelurahanData as &$data) {
            $data['percentage'] = $data['total_tps'] > 0 ? ($data['filled_tps'] / $data['total_tps']) * 100 : 0;
        }

        // Pagination for Kecamatan
        $kecamatanQuery = Kecamatan::query();
        if ($search) {
            $kecamatanQuery->where('nama_kecamatan', 'like', "%{$search}%");
        }
        $kecamatans = $kecamatanQuery->paginate(16);

        // Return view with required data
        return view('admin.suara.index', compact('calons', 'tps', 'search', 'kecamatans', 'suaraVotes', 'totalSuaraMax', 'kelurahanData'));
    }



    public function create()
    {
        $tps = TPS::all(); // Fetch TPS data
        $calons = Calon::all(); // Fetch Calon data
        return view('admin.suara.create', compact('tps', 'calons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tps_id' => 'required|exists:tps,tps_id',
            'calon_id' => 'required|exists:calons,calon_id',
            'jumlah_suara' => 'required|integer',
        ]);

        Suara::create($request->all());

        return redirect()->route('suara.index')->with('status', 'Suara created successfully.');
    }

    public function edit($id)
    {
        $suara = Suara::findOrFail($id);
        $tps = TPS::all();
        $calons = Calon::all();

        return view('admin.suara.edit', compact('suara', 'tps', 'calons'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tps_id' => 'required|exists:tps,tps_id',
            'kelurahan_id' => 'required|exists:kelurahans,kelurahan_id',
            'suara.*' => 'nullable|integer|min:0',
            'suara_ids.*' => 'nullable|exists:suara,suara_id'
        ]);

        // Iterate over each calon_id from the request
        foreach ($request->suara as $calonId => $jumlahSuara) {
            // Get the corresponding suara_id from the request
            $suaraId = $request->suara_ids[$calonId] ?? null;

            if ($suaraId) {
                // Update existing record
                $suara = Suara::find($suaraId);
                if ($suara) {
                    $suara->update([
                        'jumlah_suara' => $jumlahSuara,
                    ]);
                }
            } else {
                // Create new record if not exists
                Suara::updateOrCreate([
                    'tps_id' => $request->tps_id,
                    'kelurahan_id' => $request->kelurahan_id,
                    'calon_id' => $calonId,
                ], [
                    'jumlah_suara' => $jumlahSuara,
                ]);
            }
        }

        return redirect()->route('suara.index')->with('status', 'Votes updated successfully.');
    }

    public function updateAll(Request $request)
    {
        $request->validate([
            'tps_id' => 'required|exists:tps,tps_id',
            'kelurahan_id' => 'required|exists:kelurahans,kelurahan_id',
            'suara.*' => 'nullable|integer|min:0',
            'suara_ids.*' => 'nullable|exists:suara,suara_id'
        ]);

        foreach ($request->suara as $calonId => $jumlahSuara) {
            $suaraId = $request->suara_ids[$calonId] ?? null;

            if ($suaraId) {
                // Update existing record
                $suara = Suara::find($suaraId);
                if ($suara) {
                    $suara->update([
                        'jumlah_suara' => $jumlahSuara,
                    ]);
                }
            } else {
                // Create new record if not exists (UUID will be generated automatically)
                Suara::updateOrCreate([
                    'tps_id' => $request->tps_id,
                    'kelurahan_id' => $request->kelurahan_id,
                    'calon_id' => $calonId,
                ], [
                    'jumlah_suara' => $jumlahSuara,
                ]);
            }
        }
        return redirect()->route('suara.index')->with('status', 'Votes updated successfully.');
    }
    public function destroy($id)
    {
        $suara = Suara::findOrFail($id);
        $suara->delete();
        return redirect()->route('suara.index')->with('status', 'Suara deleted successfully.');
    }
}
