@extends('layout')

@section('content')

<div class="container mt-4 pb-4">
    <h4 class="mt-5"><i class="fas fa-user-edit"></i> Edit Profile</h4>

    @if(Session::get('success'))
        <div class="alert alert-success mt-2"> {{ session::get('success') }} </div>
    @endif

    <form class="mt-3 p-4 shadow-sm border rounded" action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user"></i> Nama</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukan password baru">
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user-tag"></i> Role</label>
            <select name="role" class="form-control" required>
                <option disabled>Pilih role</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="guest" {{ $user->role == 'guest' ? 'selected' : '' }}>Guest</option>
            </select>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('user.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

@endsection
