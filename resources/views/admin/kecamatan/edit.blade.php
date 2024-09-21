@extends('admin.layout.layouts')
@section('title', 'Admin | Edit Kecamatan')

@section('content')

    <div class="container">
        <h1>Edit Kecamatan</h1>
        <form method="POST" action="{{ route('kecamatan.update', $kecamatan->kecamatan_id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_kecamatan">Nama Kecamatan</label>
                <input type="text" name="nama_kecamatan" id="nama_kecamatan" class="form-control"
                    value="{{ $kecamatan->nama_kecamatan }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Ubah</button>
        </form>
    </div>
@endsection
