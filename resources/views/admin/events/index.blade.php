@extends('admin.layout.app')

@section('title', 'Manajemen Kegiatan Event')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-calendar-star text-primary me-2"></i>Daftar Kegiatan</h5>
        <a href="{{ route('events.create') }}" class="btn-primary-custom text-decoration-none" style="background: linear-gradient(135deg, #10b981, #059669);">
            <i class="fa-solid fa-plus"></i> Tambah Kegiatan
        </a>
    </div>

    @if($events->count() > 0)
    <div class="table-responsive">
        <table class="table table-custom mb-0 text-nowrap">
            <thead>
                <tr>
                    <th width="80">Gambar</th>
                    <th>Judul Event</th>
                    <th>Jadwal Pelaksanaan</th>
                    <th>Lokasi</th>
                    <th class="text-end" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        @else
                            <div style="width: 50px; height: 50px; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-bold text-dark mb-1">{{ Str::limit($event->title, 40) }}</div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill" style="font-size: 0.75rem;">
                            {{ $event->category->name }}
                        </span>
                    </td>
                    <td>
                        <div class="text-dark fw-medium"><i class="fa-regular fa-calendar text-muted me-1"></i> {{ \Carbon\Carbon::parse($event->event_date)->isoFormat('D MMM Y') }}</div>
                        @if($event->jam)
                            <div class="small text-muted mt-1">
                                <i class="fa-regular fa-clock me-1"></i> {{ \Carbon\Carbon::parse($event->jam)->format('H:i') }} 
                                @if($event->jam_selesai)
                                    - {{ \Carbon\Carbon::parse($event->jam_selesai)->format('H:i') }} WIB
                                @else
                                    WIB - Sels.
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="text-muted small text-truncate d-inline-block" style="max-width: 200px;" title="{{ $event->location }}">
                            <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $event->location }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('event.show', $event->id) }}" target="_blank" class="btn-action" style="background: rgba(16,185,129,0.1); color: #10b981;" title="Lihat di Web">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('events.edit', $event->id) }}" class="btn-action edit" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline" data-confirm-title="Hapus Kegiatan?" data-confirm-text="Data kegiatan beserta file fotonya akan dihapus dari server." onsubmit="confirmDelete(event, this)">
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
    
    <!-- Paginasi -->
    <div class="d-flex justify-content-end mt-4">
        {{ $events->links('pagination::bootstrap-5') }}
    </div>

    @else
    <div class="text-center py-5">
        <div style="font-size: 4rem; color: #cbd5e1; margin-bottom: 15px;"><i class="fa-solid fa-calendar-xmark"></i></div>
        <h6 class="text-muted fw-bold">Belum ada kegiatan yang didaftarkan.</h6>
        <p class="text-muted small">Mulai tambahkan kegiatan pertama Anda dengan menekan tombol Tambah di atas.</p>
    </div>
    @endif
</div>
@endsection
