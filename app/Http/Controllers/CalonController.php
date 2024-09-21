<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use Illuminate\Http\Request;

class CalonController extends Controller
{
    // Menampilkan daftar calon
    public function index()
    {
        $calons = Calon::all();
        return view('admin.calon.index', compact('calons'));
    }

    // Menampilkan form untuk membuat calon baru
    public function create()
    {
        return view('admin.calon.create');
    }

    // Menyimpan calon baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_urut' => 'required|string|max:255',
            'partai' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:1024', // Validasi file
        ]);

        $data = $request->only([
            'nama',
            'no_urut',
            'partai'
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_calon', $filename);
            $data['foto'] = 'storage/foto_calon/' . $filename;
        }

        Calon::create($data);

        return redirect()->route('calon.index')->with('status', 'Calon created successfully.');
    }

    // Menampilkan detail calon tertentu
    public function show(Calon $calon)
    {
        return view('admin.calon.show', compact('calon'));
    }

    // Menampilkan form untuk mengedit calon tertentu
    public function edit(Calon $calon)
    {
        return view('admin.calon.edit', compact('calon'));
    }

    // Memperbarui calon tertentu di database
    public function update(Request $request, Calon $calon)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_urut' => 'required|string|max:255',
            'partai' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:1024', // Validasi file
        ]);

        $data = $request->only(['nama', 'no_urut', 'partai']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($calon->foto && \Storage::exists(str_replace('storage/', 'public/', $calon->foto))) {
                \Storage::delete(str_replace('storage/', 'public/', $calon->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_calon', $filename);
            $data['foto'] = 'storage/foto_calon/' . $filename;
        }

        $calon->update($data);

        return redirect()->route('calon.index')->with('status', 'Calon updated successfully.');
    }

    // Menghapus calon tertentu dari database
    public function destroy(Calon $calon)
    {
        $calon->delete();

        return redirect()->route('calon.index')->with('status', 'Calon deleted successfully.');
    }
}
