@extends('admin.layout.layouts')
@section('content')
@section('title', 'Admin | Tambah Kecamatan')

<div class="container">
    <h1>Tambah Kecamatan</h1>
    <form method="POST" action="{{ route('kecamatan.store') }}">
        @csrf
        <div class="form-group">
            <label for="nama_kecamatan">Nama Kecamatan</label>
            <input type="text" name="nama_kecamatan" value="{{ old('nama_kecamatan') }}" id="nama_kecamatan"
                class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
