<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::orderby('created_at', 'desc')->get();
        return view('admin.kecamatan.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('admin.kecamatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:1000|unique:kecamatan',
        ]);

        Kecamatan::create([
            'kecamatan_id' => (string) Str::uuid(),
            'nama_kecamatan' => $request->input('nama_kecamatan'),
        ]);

        return redirect()->route('kecamatan.index')->with('status', 'Kecamatan created successfully!');
    }

    public function show(Kecamatan $kecamatan)
    {
        return view('admin.kecamatan.show', compact('kecamatan'));
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('admin.kecamatan.edit', compact('kecamatan'));
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
        ]);

        $kecamatan->update([
            'nama_kecamatan' => $request->input('nama_kecamatan'),
        ]);

        return redirect()->route('kecamatan.index')->with('status', 'Kecamatan updated successfully.');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        Kelurahan::where('kecamatan_id', $kecamatan->kecamatan_id)->delete();
        $kecamatan->delete();
        return redirect()->route('kecamatan.index')->with('status', 'Kecamatan deleted successfully.');
    }
}
