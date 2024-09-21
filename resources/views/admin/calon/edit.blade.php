@extends('admin.layout.layouts')

@section('title', 'Admin | Edit Calon')

@section('content')
    <div class="container">
        <h1>Edit Calon</h1>
        <form action="{{ route('calon.update', $calon) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $calon->nama) }}"
                    required>
                @error('nama')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_urut">Nomor Urut</label>
                <input type="text" name="no_urut" id="no_urut" class="form-control"
                    value="{{ old('no_urut', $calon->no_urut) }}" required>
                @error('no_urut')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="partai">Partai</label>
                <input type="text" name="partai" id="partai" class="form-control"
                    value="{{ old('partai', $calon->partai) }}">
                @error('partai')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="foto">Foto (jpg, png, jpeg - max 1MB)</label>
                <input type="file" accept=".png,.jpg,.jpeg" name="foto" id="foto" class="form-control">
                <br>
                @if ($calon->foto)
                    <img id="fotoPreview" src="{{ asset($calon->foto) }}" alt="Foto Calon" width="100">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('calon.index') }}" class="btn btn-secondary">Kembali</a>
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
                };
                reader.readAsDataURL(file);
            } else {
                // Jika tidak ada file yang dipilih, gunakan URL default atau sembunyikan preview
                preview.src = '{{ asset($calon->foto) }}';
            }
        });
    </script>
@endsection
