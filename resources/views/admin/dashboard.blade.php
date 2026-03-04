@extends('admin.layout.app')

@section('title', 'Dashboard Statistik')

@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="admin-card text-center d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #4f46e5, #3b82f6); color: white;">
            <div style="font-size: 3rem; margin-bottom: 10px; opacity: 0.9;"><i class="fa-solid fa-tags"></i></div>
            <h5 style="font-weight: 600; font-size: 1.1rem; opacity: 0.9;">Total Kategori</h5>
            <h2 style="font-weight: 800; font-size: 2.5rem; margin: 0;">{{ \App\Models\Category::count() }}</h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-card text-center d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
            <div style="font-size: 3rem; margin-bottom: 10px; opacity: 0.9;"><i class="fa-solid fa-calendar-check"></i></div>
            <h5 style="font-weight: 600; font-size: 1.1rem; opacity: 0.9;">Total Kegiatan</h5>
            <h2 style="font-weight: 800; font-size: 2.5rem; margin: 0;">{{ \App\Models\Event::count() }}</h2>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-lg-12">
        <div class="admin-card">
            <h5 class="mb-4 fw-bold text-dark"><i class="fa-solid fa-bolt text-warning me-2"></i>Aktivitas Cepat</h5>
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('events.create') }}" class="btn-primary-custom text-decoration-none">
                    <i class="fa-solid fa-plus"></i> Tambah Kegiatan Baru
                </a>
                <a href="{{ route('categories.create') }}" class="btn-primary-custom text-decoration-none" style="background: linear-gradient(135deg, #64748b, #475569);">
                    <i class="fa-solid fa-folder-plus"></i> Tambah Kategori
                </a>
                <a href="/" target="_blank" class="btn-primary-custom text-decoration-none" style="background: linear-gradient(135deg, #14b8a6, #0d9488);">
                    <i class="fa-solid fa-globe"></i> Lihat Web Publik
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
