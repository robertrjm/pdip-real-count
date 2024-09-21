@extends('admin.layout.layouts')
@section('content')
    <div class="container">
        <h1>Kelurahan Details</h1>
        <p><strong>ID:</strong> {{ $kelurahan->kelurahan_id }}</p>
        <p><strong>Nama Kelurahan:</strong> {{ $kelurahan->nama_kelurahan }}</p>
        <p><strong>Kecamatan:</strong> {{ $kelurahan->kecamatan->nama_kecamatan }}</p>
        <a href="{{ route('kelurahan.edit', $kelurahan->kelurahan_id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('kelurahan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
