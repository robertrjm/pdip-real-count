@extends('admin.layout.layouts')
@section('title', 'Admin | TPS Detail')

@section('content')
    <div class="container">
        <h1>Detail TPS</h1>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">TPS: {{ $tps->nama_tps }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Kelurahan:</strong> {{ $tps->nama_kelurahan }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('tps.edit', $tps->tps_id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('tps.destroy', $tps->tps_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <a href="{{ route('tps.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
