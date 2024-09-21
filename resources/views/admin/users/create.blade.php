@extends('admin.layout.layouts')
@section('title', 'Admin | Tambah Users')
@section('content')
    <h1>Tambah User</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama"
                value="{{ old('name') }}" required>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email"
                value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password"
                required>
            @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                placeholder="Konfirmasi password" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control">
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('role'))
                <span class="text-danger">{{ $errors->first('role') }}</span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
