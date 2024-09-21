@extends('admin.layout.layouts')
@section('content')
    <div class="container">
        <h1>Create Kelurahan</h1>
        <br>
        <form method="POST" action="{{ route('kelurahan.store') }}">
            @csrf
            <div class="form-group">
                <label for="nama_kelurahan">Nama Kelurahan</label>
                <input type="text" name="nama_kelurahan" id="nama_kelurahan" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="kecamatan_id">Kecamatan</label>
                <select name="kecamatan_id" id="exampleFormControlSelect2" class="form-select" required>
                    <option>-- Silahkan Pilih Kecamatan --</option>
                    @foreach ($kecamatan as $kecamatan)
                        <option value="{{ $kecamatan->kecamatan_id }}">{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
@endsection
