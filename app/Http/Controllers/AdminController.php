<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Calon;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Suara;
use App\Models\Tps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Can;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelurahan = Kelurahan::count();
        $kec = Kecamatan::count();
        $tps = Tps::count();
        $calon = Calon::count();
        $tampil = Calon::get();
        $suara = Suara::get();
        // Hitung total suara seluruh calon
        $totalSuaraSemuaCalon = $suara->sum('jumlah_suara');
        // Menghitung persentase suara per calon
        $suaraPerCalon = $tampil->map(function ($calonItem) use ($suara, $totalSuaraSemuaCalon) {
            $jumlahSuaraCalon = $suara->where('calon_id', $calonItem->calon_id)->sum('jumlah_suara');
            $persentaseSuara = ($totalSuaraSemuaCalon > 0) ? ($jumlahSuaraCalon / $totalSuaraSemuaCalon) * 100 : 0;
            return [
                'calon' => $calonItem,
                'jumlah_suara' => $jumlahSuaraCalon,
                'persentase_suara' => $persentaseSuara,
            ];
        });
        // TPS yang sudah terisi
        $filledTpsCount = Suara::distinct('tps_id')->count('tps_id');
        // TPS yang belum terisi
        $remainingTpsCount = $tps - $filledTpsCount;
        // Data untuk grafik (hanya ambil nama dan suara per calon)
        $calonNames = $suaraPerCalon->pluck('calon.nama')->toArray();
        $suaraCalon = $suaraPerCalon->pluck('jumlah_suara')->toArray();
        $suaraPercentage = $suaraPerCalon->pluck('persentase_suara')->toArray();

        return view('admin.dashboard', compact(
            'kelurahan',
            'kec',
            'tampil',
            'suara',
            'tps',
            'calon',
            'suaraPerCalon',
            'totalSuaraSemuaCalon',
            'filledTpsCount',
            'remainingTpsCount',
            'calonNames',
            'suaraCalon',
            'suaraPercentage',
        ));
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak benar.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password updated successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
