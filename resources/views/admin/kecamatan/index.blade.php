@extends('admin.layout.layouts')
@section('title', 'Admin | Kecamatan')

@section('content')
    <div class="container">
        <h1>Data Kecamatan </h1>
        <a href="{{ route('kecamatan.create') }}" class="btn btn-primary">+ Kecamatan</a>
        <br>


        <br>
        <table class="table table-hover" id="exampleTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kecamatan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kecamatans as $kecamatan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kecamatan->nama_kecamatan }}</td>
                        <td>
                            <a href="{{ route('kecamatan.show', $kecamatan->kecamatan_id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('kecamatan.edit', $kecamatan->kecamatan_id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('kecamatan.destroy', $kecamatan->kecamatan_id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
