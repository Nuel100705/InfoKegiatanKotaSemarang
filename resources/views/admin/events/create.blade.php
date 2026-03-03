@extends('admin.layout.app')

@section('title', 'Tambah Kegiatan Baru')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dmuy/timepicker@2.0.2/dist/mdtimepicker.min.css">
<style>
    .map-container { border-radius: 12px; overflow: hidden; border: 2px solid #e2e8f0; position: relative; }
    .map-overlay { position: absolute; top: 10px; right: 10px; z-index: 1000; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 250px; }
</style>
@endsection

@section('content')
<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card h-100 mb-0">
                <h6 class="fw-bold mb-4 text-primary border-bottom pb-2">Informasi Utama</h6>
                
                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg" placeholder="Masukkan nama event..." value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi & Rincian <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="6" placeholder="Beri tau orang-orang detail tentang kegiatan ini..." required>{{ old('description') }}</textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="date" name="event_date" class="form-control" value="{{ old('event_date') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam</label>
                        <input type="text" name="jam" class="form-control timepicker bg-white" placeholder="Pilih Jam (AM/PM)" value="{{ old('jam') }}" readonly style="cursor: pointer;">
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <h6 class="fw-bold mb-3 text-primary border-bottom pb-2">Media Resolusi Tinggi</h6>
                
                <div class="mb-3">
                    <label class="form-label"><i class="fa-regular fa-image me-1"></i> Poster Kegiatan (Gambar)</label>
                    <input type="file" name="image" id="imageInput" class="form-control" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                    <small class="text-muted mt-1 d-block">Rekomendasi ukuran: 1200x630 .jpg/.png</small>
                </div>

                <div class="mb-0">
                    <label class="form-label"><i class="fa-solid fa-video me-1"></i> Video Teaser (Opsional)</label>
                    <input type="file" name="video" class="form-control" accept="video/*">
                    <small class="text-muted mt-1 d-block">Format .mp4 maksimal 10MB.</small>
                </div>
            </div>

            <div class="admin-card mb-0" style="background: #f8fafc;">
                <button type="submit" class="btn-primary-custom w-100 justify-content-center mb-2 p-3" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-paper-plane"></i> Terbitkan Kegiatan
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
                        <div class="mb-3 position-relative">
                            <label class="form-label">Cari & Tandai Peta</label>
                            <div class="input-group">
                                <input type="text" id="location-search" class="form-control" placeholder="Contoh: Simpang Lima" onkeyup="delaySuggestLocation()" autocomplete="off">
                                <button type="button" onclick="searchLocation()" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                            <ul id="suggestion-list" class="list-group position-absolute w-100 shadow d-none" style="z-index: 1050; max-height: 250px; overflow-y: auto; top: 100%;"></ul>
                            <small class="text-muted d-block mt-2">Cari nama tempat, lalu <b>klik hasil pencarian atau map area</b>.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi Tertulis <span class="text-danger">*</span></label>
                            <textarea name="location" id="location" class="form-control bg-light" rows="3" readonly required>{{ old('location') }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control bg-light" readonly value="{{ old('latitude') }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control bg-light" readonly value="{{ old('longitude') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="map-container">
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
<script src="https://cdn.jsdelivr.net/npm/@dmuy/timepicker@2.0.2/dist/mdtimepicker.min.js"></script>
<script>
    // Inisialisasi Material Design Time Picker dengan AM/PM (12-hour format)
    mdtimepicker('.timepicker', {
        format: 'hh:mm tt',
        type: 'time',
        hourPadding: true,
        is24hour: false,
        theme: 'red'
    });

    // Koordinat pusat default (Semarang)
    var default_lat = -6.9932;
    var default_lon = 110.4203;

    var map = L.map('map', {
        center: [default_lat, default_lon],
        zoom: 13,
        minZoom: 11,
        maxBounds: [
            [-7.15, 110.20], // Batas Barat Daya (South-West)
            [-6.85, 110.55]  // Batas Timur Laut (North-East)
        ],
        maxBoundsViscosity: 1.0 // Mencegah map digeser keluar batas
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([default_lat, default_lon], {draggable: true}).addTo(map)
        .bindPopup("Geser pin ini atau klik area map.").openPopup();

    function updateFormFromMarker(lat, lng, loc_name) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        if(loc_name) document.getElementById('location').value = loc_name;
        
        // Reverse Geocoding jika bukan dari search query
        if(!loc_name){
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if(data.display_name) {
                    document.getElementById('location').value = data.display_name;
                    marker.bindPopup(data.display_name).openPopup();
                }
            });
        }
    }

    // 🔍 SEARCH API Nominatim
    function searchLocation() {
        let query = document.getElementById('location-search').value;
        if(query.trim() === '') return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=1&viewbox=110.20,-6.85,110.55,-7.15&bounded=1`)
        .then(res => res.json())
        .then(data => {
            if (data.length > 0) {
                let lat = data[0].lat;
                let lon = data[0].lon;
                let name = data[0].display_name;

                map.flyTo([lat, lon], 16);
                marker.setLatLng([lat, lon]).bindPopup(name).openPopup();
                updateFormFromMarker(lat, lon, name);
                document.getElementById('suggestion-list').classList.add('d-none');
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Pencarian Gagal',
                    text: 'Lokasi spesifik tidak ditemukan. Cobalah memakai kata kunci yang lebih luas atau nama jalan besar.',
                    confirmButtonColor: '#ef4444'
                });
            }
        });
    }

    // 🔍 AUTOCOMPLETE SUGGESTIONS
    let suggestTimeout;
    function delaySuggestLocation() {
        clearTimeout(suggestTimeout);
        let query = document.getElementById('location-search').value;
        let list = document.getElementById('suggestion-list');
        
        if(query.trim().length < 3) {
            list.classList.add('d-none');
            return;
        }
        
        suggestTimeout = setTimeout(() => {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=5&viewbox=110.20,-6.85,110.55,-7.15&bounded=1`)
            .then(res => res.json())
            .then(data => {
                list.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        let li = document.createElement('li');
                        li.className = 'list-group-item list-group-item-action px-3 py-2';
                        li.style.cursor = 'pointer';
                        
                        let parts = item.display_name.split(',');
                        let mainName = parts[0];
                        let address = parts.slice(1).join(',').trim();

                        li.innerHTML = `<div class="fw-bold"><i class="fa-solid fa-map-pin text-danger me-2"></i>${mainName}</div>
                                        <div class="text-muted small ms-4 text-truncate">${address}</div>`;
                        
                        li.onclick = function() {
                            map.flyTo([item.lat, item.lon], 16);
                            marker.setLatLng([item.lat, item.lon]).bindPopup(item.display_name).openPopup();
                            updateFormFromMarker(item.lat, item.lon, item.display_name);
                            document.getElementById('location-search').value = mainName;
                            list.classList.add('d-none');
                        };
                        list.appendChild(li);
                    });
                    list.classList.remove('d-none');
                } else {
                    list.innerHTML = `<li class="list-group-item text-muted text-center py-2 small">Lokasi tidak ditemukan</li>`;
                    list.classList.remove('d-none');
                }
            });
        }, 500);
    }

    // Hilangkan dropdown jika klik di luar box pencarian
    document.addEventListener('click', function(e) {
        let searchBox = document.getElementById('location-search');
        let suggestList = document.getElementById('suggestion-list');
        if(searchBox && suggestList) {
            if(!searchBox.contains(e.target) && !suggestList.contains(e.target)) {
                suggestList.classList.add('d-none');
            }
        }
    });

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

    // 🛡️ Alert Validasi File JPG/PNG
    document.getElementById('imageInput').addEventListener('change', function(e) {
        var file = this.files[0];
        if (file) {
            var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Format Ditolak!',
                    text: 'Mohon hanya unggah file gambar atau poster dengan format murni .JPG atau .PNG saja.',
                    confirmButtonColor: '#ef4444'
                });
                this.value = ''; // Reset file input
            }
        }
    });
</script>
@endsection
