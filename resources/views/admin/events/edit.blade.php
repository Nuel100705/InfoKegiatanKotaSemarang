@extends('admin.layout.app')

@section('title', 'Perbarui Kegiatan Event')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<style>
    .map-container { border-radius: 12px; overflow: hidden; border: 2px solid #e2e8f0; position: relative; }
    .map-overlay { position: absolute; top: 10px; left: 10px; z-index: 1000; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 250px; }
    .media-preview-box { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 10px; text-align: center; }
    .media-preview-box img, .media-preview-box video { max-width: 100%; border-radius: 8px; max-height: 200px; object-fit: cover; }
</style>
@endsection

@section('content')
<form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card h-100 mb-0">
                <h6 class="fw-bold mb-4 text-primary border-bottom pb-2">Informasi Utama</h6>
                
                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $event->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi & Rincian <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="6" required>{{ old('description', $event->description) }}</textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="date" name="event_date" class="form-control" value="{{ old('event_date', $event->event_date) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam (WIB)</label>
                        <input type="time" name="jam" class="form-control" value="{{ old('jam', $event->jam ? \Carbon\Carbon::parse($event->jam)->format('H:i') : '') }}">
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <h6 class="fw-bold mb-3 text-primary border-bottom pb-2">Media Resolusi Tinggi</h6>
                
                <div class="mb-4">
                    <label class="form-label"><i class="fa-regular fa-image me-1"></i> Poster Kegiatan (Gambar)</label>
                    <input type="file" name="image" class="form-control mb-2" accept="image/*">
                    @if($event->image)
                    <div class="media-preview-box">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="Preview">
                        <small class="d-block mt-2 text-muted">Abaikan file jika tidak ingin mengubah poster.</small>
                    </div>
                    @else
                    <small class="text-muted d-block">Tidak ada poster diunggah.</small>
                    @endif
                </div>

                <div class="mb-0">
                    <label class="form-label"><i class="fa-solid fa-video me-1"></i> Video Teaser (Opsional)</label>
                    <input type="file" name="video" class="form-control mb-2" accept="video/*">
                    @if($event->video)
                    <div class="media-preview-box">
                        <video controls>
                            <source src="{{ asset('storage/' . $event->video) }}" type="video/mp4">
                        </video>
                        <small class="d-block mt-2 text-muted">Abaikan file jika tidak ingin mengubah video.</small>
                    </div>
                    @else
                    <small class="text-muted d-block">Tidak ada video diunggah.</small>
                    @endif
                </div>
            </div>

            <div class="admin-card mb-0" style="background: #f8fafc;">
                <button type="submit" class="btn-primary-custom w-100 justify-content-center mb-2 p-3" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-check-double"></i> Simpan Perubahan
                </button>
                <a href="{{ route('events.index') }}" class="btn-primary-custom w-100 justify-content-center" style="background: white; color: #475569; border: 1px solid #cbd5e1;">
                    Batal & Kembali
                </a>
            </div>
        </div>

        <div class="col-12">
            <div class="admin-card">
                <h6 class="fw-bold mb-4 text-primary border-bottom pb-2">Lokasi Terperinci (Koordinat Google Maps)</h6>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Cari & Tandai Peta</label>
                            <div class="input-group">
                                <input type="text" id="location-search" class="form-control" placeholder="Ketik nama lokasi baru...">
                                <button type="button" onclick="searchLocation()" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                            <small class="text-muted d-block mt-2">Cari nama tempat, lalu klik hasil pencarian untuk memindahkan pin, atau geser pin manual.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teks Lokasi Saat Ini <span class="text-danger">*</span></label>
                            <textarea name="location" id="location" class="form-control bg-light" rows="3" readonly required>{{ old('location', $event->location) }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control bg-light" readonly value="{{ old('latitude', $event->latitude) }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control bg-light" readonly value="{{ old('longitude', $event->longitude) }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="map-container">
                            <div class="map-overlay">
                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-map-pin"></i> Lokasi Saat Ini</span>
                                <div class="mt-1 small fw-bold text-truncate" id="overlay-text">{{ $event->location }}</div>
                            </div>
                            <div id="map" style="height: 450px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Ambil Data DB Lama
    var db_lat = {{ $event->latitude ?? -6.9932 }};
    var db_lon = {{ $event->longitude ?? 110.4203 }};
    var db_loc = `{!! addslashes($event->location) !!}`;

    var map = L.map('map').setView([db_lat, db_lon], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([db_lat, db_lon], {draggable: true}).addTo(map)
        .bindPopup(db_loc ? db_loc : "Geser pin ini").openPopup();

    function updateFormFromMarker(lat, lng, loc_name) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        if(loc_name) {
            document.getElementById('location').value = loc_name;
            document.getElementById('overlay-text').innerText = loc_name;
        }
        
        // Reverse Geocoding via Nominatim API if location name not explicitly given
        if(!loc_name){
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if(data.display_name) {
                    document.getElementById('location').value = data.display_name;
                    document.getElementById('overlay-text').innerText = data.display_name;
                    marker.bindPopup(data.display_name).openPopup();
                }
            });
        }
    }

    // 🔍 SEARCH API Nominatim
    function searchLocation() {
        let query = document.getElementById('location-search').value;
        if(query.trim() === '') return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=1`)
        .then(res => res.json())
        .then(data => {
            if (data.length > 0) {
                let lat = data[0].lat;
                let lon = data[0].lon;
                let name = data[0].display_name;

                map.flyTo([lat, lon], 16);
                marker.setLatLng([lat, lon]).bindPopup(name).openPopup();
                updateFormFromMarker(lat, lon, name);
            } else {
                alert('Lokasi spesifik tidak ditemukan, cobalah keyword yang lebih luas.');
            }
        });
    }

    // Saat map diclick
    map.on('click', function(e){
        let lat = e.latlng.lat;
        let lon = e.latlng.lng;
        marker.setLatLng([lat, lon]);
        updateFormFromMarker(lat, lon, null);
    });

    // Saat marker dishift (drag)
    marker.on('dragend', function(e) {
        let lat = marker.getLatLng().lat;
        let lon = marker.getLatLng().lng;
        updateFormFromMarker(lat, lon, null);
    });
</script>
@endsection
