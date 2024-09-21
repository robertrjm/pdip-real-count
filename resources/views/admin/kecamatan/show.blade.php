@extends('admin.layout.layouts')
@section('title', 'Admin | Show Kecamatan')

@section('content')
    <div class="container">
        <h1>Kecamatan Details</h1>
        <p><strong>ID:</strong> {{ $kecamatan->kecamatan_id }}</p>
        <p><strong>Nama Kecamatan:</strong> {{ $kecamatan->nama_kecamatan }}</p>
        <a href="{{ route('kecamatan.edit', $kecamatan->kecamatan_id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('kecamatan.index') }}" class="btn btn-secondary">Kembali </a>
    </div>
@endsection
