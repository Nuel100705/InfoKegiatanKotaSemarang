@extends('admin.layout.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-tags text-primary me-2"></i>Daftar Kategori</h5>
        <a href="{{ route('categories.create') }}" class="btn-primary-custom text-decoration-none">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </a>
    </div>

    @if($categories->count() > 0)
    <div class="table-responsive">
        <table class="table table-custom text-nowrap">
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th class="text-end" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $index => $category)
                <tr>
                    <td><span class="fw-bold text-muted">{{ $index + 1 }}</span></td>
                    <td class="fw-bold text-dark">{{ $category->name }}</td>
                    <td class="text-muted"><span class="badge bg-light text-dark border">{{ $category->slug }}</span></td>
                    <td class="text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('categories.edit', $category->slug) }}" class="btn-action edit" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category->slug) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Semua kegiatan berelasi mungkin akan error jika tidak dipindah.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-5">
        <div style="font-size: 3rem; color: #cbd5e1; margin-bottom: 10px;"><i class="fa-regular fa-folder-open"></i></div>
        <h6 class="text-muted fw-bold">Belum ada kategori</h6>
        <p class="text-muted small">Mulai tambahkan kategori pertama untuk mengelompokkan kegiatan.</p>
    </div>
    @endif
</div>
@endsection
