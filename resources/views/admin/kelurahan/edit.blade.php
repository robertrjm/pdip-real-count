@extends('admin.layout.layouts')
@section('content')
    <div class="container">
        <h1>Edit Kelurahan</h1>
        <form method="POST" action="{{ route('kelurahan.update', $kelurahan->kelurahan_id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_kelurahan">Nama Kelurahan</label>
                <input type="text" name="nama_kelurahan" id="nama_kelurahan" class="form-control"
                    value="{{ $kelurahan->nama_kelurahan }}" required>
            </div>
            <div class="form-group">
                <label for="kecamatan_id">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="form-select" required>
                    @foreach ($kecamatan as $kecamatan)
                        <option value="{{ $kecamatan->kecamatan_id }}"
                            {{ $kelurahan->kecamatan_id === $kecamatan->kecamatan_id ? 'selected' : '' }}>
                            {{ $kecamatan->nama_kecamatan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
