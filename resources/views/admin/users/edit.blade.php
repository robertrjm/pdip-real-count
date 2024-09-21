@extends('admin.layout.layouts')
@section('title', 'Admin | Edit Users')
@section('content')
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password (Kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control">
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>{{ $role }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
@endsection
