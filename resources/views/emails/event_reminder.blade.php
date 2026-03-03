<x-mail::message>
# 🔔 Pengingat Kegiatan: {{ $event->title }}

Halo! Ini adalah pengingat otomatis bahwa kegiatan berikut akan segera dimulai dalam waktu **{{ $label }}**.

**Detail Acara:**
- **📍 Lokasi:** {{ $event->location }}
- **📅 Tanggal:** {{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM Y') }}
@if($event->jam)
- **⏰ Waktu:** {{ \Carbon\Carbon::parse($event->jam)->format('H:i') }} WIB
@endif

Silakan cek informasi selengkapnya melalui tombol di bawah ini.

<x-mail::button :url="url('/kegiatan/' . $event->id)">
Lihat Detail Kegiatan
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
