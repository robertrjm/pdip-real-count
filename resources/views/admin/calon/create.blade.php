@extends('admin.layout.layouts')
@section('title', 'Admin | Tambah Calon')

@section('content')
    <div class="container">
        <h1>Tambah Calon</h1>
        <form action="{{ route('calon.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_urut">Nomor Urut</label>
                <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ old('no_urut') }}"
                    required>
                @error('no_urut')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="partai">Partai</label>
                <input type="text" name="partai" id="partai" class="form-control" value="{{ old('partai') }}">
                @error('partai')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="foto">Foto (jpg, png, jpeg - max 1MB)</label>
                <input type="file" name="foto" id="foto" accept=".png,.jpg,.jpeg" class="form-control" required>
                @error('foto')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                <div class="mt-3">
                    <img id="fotoPreview" src="#" alt="Foto Preview" style="display: none; max-width: 200px;">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('fotoPreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        });
    </script>
@endsection
