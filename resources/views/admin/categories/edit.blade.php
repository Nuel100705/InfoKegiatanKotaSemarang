@extends('admin.layout.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="admin-card" style="max-width: 600px; margin: 0 auto;">
    <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Perbarui Kategori</h5>

    <form action="{{ route('categories.update', $category->slug) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            @error('name') <small class="text-danger mt-1 d-block"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small> @enderror
        </div>

        <div class="d-flex gap-2 mt-4 pt-2 border-top">
            <button type="submit" class="btn-primary-custom flex-grow-1 justify-content-center">
                <i class="fa-solid fa-check"></i> Simpan Perubahan
            </button>
            <a href="{{ route('categories.index') }}" class="btn-primary-custom" style="background: #f1f5f9; color: #475569; padding: 10px 20px;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
