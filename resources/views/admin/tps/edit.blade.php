@extends('admin.layout.layouts')
@section('title', 'Admin | Edit TPS')

@section('content')
    <div class="container">
        <h1>Edit TPS</h1>
        <form method="POST" action="{{ route('tps.update', $tps->tps_id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="kelurahan_id">Kelurahan</label>
                <select disabled name="kelurahan_id" id="kelurahan_id" class="form-select" required>
                    @foreach ($kelurahans as $kelurahan)
                        <option value="{{ $kelurahan->kelurahan_id }}"
                            {{ $kelurahan->kelurahan_id == $tps->kelurahan_id ? 'selected' : '' }}>
                            {{ $kelurahan->nama_kelurahan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nama_tps">Nama TPS</label>
                <input type="text" name="nama_tps" id="nama_tps" class="form-control" value="{{ $tps->nama_tps }}"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('tps.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
