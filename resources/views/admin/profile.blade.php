@extends('admin.layout.app')

@section('content')
<div class="container mt-4">

    <h4>Profil Admin</h4>



    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf

        <!-- DATA PROFIL -->
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $admin->name }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $admin->email }}">
        </div>

        <hr>

        <h5>Ganti Password (Opsional)</h5>

        <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" name="current_password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="new_password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="form-control">
        </div>

        <button class="btn btn-primary">Update Profil</button>
    </form>

</div>
@endsection