@extends('admin.layout.layouts')
@section('title', 'Admin | Kelurahan')
@section('content')
@section('content')
    <div class="container">
        <h1>Daftar Calon</h1>
        <a href="{{ route('calon.create') }}" class="btn btn-primary">Tambah Calon</a>
        <br>
        <br>
        <table class="table table-hover" id="exampleTable">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nomor Urut</th>
                    <th>Partai</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($calons as $calon)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $calon->nama }}</td>
                        <td>{{ $calon->no_urut }}</td>
                        <td>{{ $calon->partai }}</td>
                        <td>
                            @if ($calon->foto)
                                <a target="_blank" href="{{ asset($calon->foto) }}"><img src="{{ asset($calon->foto) }}"
                                        alt="Foto Calon" width="100%"></a>
                            @endif
                        </td>
                        <td>
                            {{-- <a href="{{ route('calon.show', $calon) }}" class="btn btn-info">Lihat</a> --}}
                            <a href="{{ route('calon.edit', $calon) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('calon.destroy', $calon) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
