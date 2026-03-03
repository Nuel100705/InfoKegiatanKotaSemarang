<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - Info Kegiatan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- LEAFLET CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" crossorigin="" />

    <style>
        /* --- 1. Base Styles --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            padding-top: 70px;
            overflow-x: hidden;
        }

        /* --- 2. Hero Image/Video Section --- */
        .event-hero {
            width: 100%;
            height: 50vh;
            min-height: 400px;
            max-height: 550px;
            position: relative;
            background-color: #1e293b;
            margin-bottom: -100px;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            z-index: 1;
        }

        .hero-img, .hero-video { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            transition: transform 0.6s ease;
        }
        
        .event-hero:hover .hero-img {
            transform: scale(1.03);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.85) 0%, rgba(15,23,42,0.1) 60%, transparent 100%);
            z-index: 2;
            pointer-events: none;
        }

        .hero-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ef4444 0%, #991b1b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.15);
            font-size: 8rem;
        }

        /* --- 3. Content Container --- */
        .main-content { position: relative; z-index: 10; padding-bottom: 4rem; }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            color: #1e293b;
            font-weight: 600;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 30px;
            margin-bottom: 2.5rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,1);
        }
        
        .btn-back:hover { 
            color: #ef4444; 
            transform: translateX(-5px); 
            background: white;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .content-card {
            background: white;
            border-radius: 28px;
            padding: 3.5rem;
            box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.05), 0 10px 15px -5px rgba(0, 0, 0, 0.02);
            margin-bottom: 2rem;
            border: 1px solid #f8fafc;
        }

        h1.event-title { 
            font-weight: 800; 
            font-size: 2.8rem; 
            color: #1e293b; 
            margin-bottom: 1.5rem; 
            line-height: 1.25;
            letter-spacing: -0.5px;
        }
        
        hr.divider-modern {
            height: 4px;
            width: 60px;
            background: linear-gradient(to right, #ef4444, #f97316);
            border: none;
            border-radius: 5px;
            opacity: 1;
            margin: 1.5rem 0 2rem;
        }

        .event-description { 
            font-size: 1.08rem; 
            line-height: 1.9; 
            color: #475569; 
            white-space: pre-line; 
        }

        /* --- Sidebar Info Box --- */
        .info-card { 
            background: white; 
            border-radius: 28px; 
            padding: 2.5rem; 
            box-shadow: 0 15px 35px -5px rgba(0,0,0,0.06); 
            border: 1px solid #f8fafc; 
            position: sticky; 
            top: 100px; 
        }
        
        .info-card h5 {
            font-weight: 800;
            font-size: 1.4rem;
            color: #1e293b;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .info-card h5 i {
            color: #ef4444;
        }
        
        .info-item { display: flex; align-items: flex-start; margin-bottom: 2rem; }
        
        .info-icon { 
            width: 50px; height: 50px; 
            background: linear-gradient(135deg, #fee2e2, #fecaca); 
            color: #ef4444; 
            border-radius: 16px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.3rem; margin-right: 18px; flex-shrink: 0; 
        }
        
        .info-label { font-size: 0.85rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; }
        .info-value { font-weight: 600; color: #1e293b; font-size: 1.05rem; line-height: 1.4; }
        
        .calendar-badge { 
            text-align: center; 
            background: #fff; 
            border: 2px solid #f1f5f9; 
            border-radius: 16px; 
            overflow: hidden; 
            width: 70px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
            flex-shrink: 0; margin-right: 18px; 
        }
        .cal-month { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; font-size: 0.75rem; font-weight: 700; padding: 5px 0; text-transform: uppercase; letter-spacing: 1px;}
        .cal-day { font-size: 1.5rem; font-weight: 800; padding: 6px 0; color: #1e293b; background: white;}

        /* Map styling */
        .map-wrapper {
            border-radius: 18px;
            overflow: hidden;
            border: 2px solid #f1f5f9;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }
        
        .btn-map { 
            width: 100%; 
            background-color: transparent; 
            color: #ef4444; 
            font-weight: 700; 
            border: 2px dashed #cbd5e1; 
            padding: 14px; 
            border-radius: 16px; 
            transition: all 0.3s; 
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }
        .btn-map:hover { background-color: #fef2f2; border-color: #ef4444; transform: translateY(-2px); }

        /* Button Calendar */
        .btn-calendar {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6, #4f46e5);
            color: white;
            font-weight: 700;
            border: none;
            padding: 15px;
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
            margin-top: 25px;
        }
        .btn-calendar:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.4); 
            color: white;
        }

        @media (max-width: 991px) {
            .content-card { padding: 2rem; }
            h1.event-title { font-size: 2rem; }
            .event-hero { height: 40vh; margin-bottom: -50px; }
        }
    </style>
</head>
<body>

    @include('public.components.navbar')

    <div class="event-hero" data-aos="fade-in" data-aos-duration="1000">
        @if($event->video)
            <video class="hero-video" controls>
                <source src="{{ asset('storage/' . $event->video) }}" type="video/mp4">
                Video tidak didukung browser ini.
            </video>
        @elseif($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="hero-img">
            <div class="hero-overlay"></div>
        @else
            <div class="hero-placeholder">
                <i class="fa-regular fa-image"></i>
            </div>
            <div class="hero-overlay"></div>
        @endif
    </div>

    <div class="container main-content">
        
        <a href="{{ url()->previous() }}" class="btn-back" data-aos="fade-down" data-aos-delay="200">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>

        <div class="row g-5">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="300">
                <div class="content-card">
                    <h1 class="event-title">{{ $event->title }}</h1>
                    
                    <hr class="divider-modern">
                    
                    <div class="event-description">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="400">
                <div class="info-card">
                    <h5><i class="fa-solid fa-circle-info"></i> Detail Acara</h5>

                    <div class="info-item">
                        <div class="calendar-badge">
                            <div class="cal-month">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                            <div class="cal-day">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                        </div>
                        <div>
                            <div class="info-label">Tanggal Pelaksanaan</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM Y') }} 
                                @if($event->jam)
                                    <br><span class="text-primary"><i class="fa-regular fa-clock me-1"></i> {{ \Carbon\Carbon::parse($event->jam)->format('H:i') }} WIB</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <div class="info-label">Lokasi Acara</div>
                            <div class="info-value">{{ $event->location }}</div>
                        </div>
                    </div>

                    @if($event->latitude && $event->longitude)
                    <div class="map-wrapper">
                        <div id="public-map" style="height: 250px; width: 100%; min-height: 250px; display: block;"></div>
                    </div>
                    
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $event->latitude }},{{ $event->longitude }}" target="_blank" class="btn btn-map text-center">
                        <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> Petunjuk Arah di Maps
                    </a>
                    @else
                    <button class="btn btn-map text-center" disabled>
                        <i class="fa-solid fa-map-pin me-2"></i> Titik Koordinat Belum Diatur
                    </button>
                    @endif



                    {{-- ===== TOMBOL KALENDER ===== --}}
                    @php
                        $calTitle = urlencode($event->title);
                        $calDetails = urlencode(strip_tags($event->description));
                        $calLocation = urlencode($event->location);
                        
                        $startDateTime = \Carbon\Carbon::parse($event->event_date);
                        if($event->jam) {
                            $startDateTime->setTimeFromTimeString($event->jam);
                        } else {
                            $startDateTime->startOfDay();
                        }
                        
                        $endDateTime = clone $startDateTime;
                        if($event->jam) {
                            $endDateTime->addHours(2);
                        } else {
                            $endDateTime->endOfDay();
                        }

                        $dates = $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis');
                        $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$dates}&details={$calDetails}&location={$calLocation}";
                    @endphp

                    <a href="{{ $googleCalUrl }}" target="_blank" class="btn-calendar">
                        <i class="fa-regular fa-calendar-plus"></i>
                        <span>Tambahkan ke Kalender</span>
                    </a>
                    {{-- ===== END TOMBOL KALENDER ===== --}}

                </div>
            </div>
        </div>
    </div>

    @include('public.components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js" crossorigin=""></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
                easing: 'ease-out-cubic',
            });

            @if($event->latitude && $event->longitude)
            setTimeout(function() {
                try {
                    if (typeof L === 'undefined') throw new Error("Library peta (Leaflet) gagal dimuat.");
                    
                    var lat = parseFloat("{{ $event->latitude }}");
                    var lon = parseFloat("{{ $event->longitude }}");

                    if (isNaN(lat) || isNaN(lon)) throw new Error("Koordinat tidak valid: " + "{{ $event->latitude }}" + ", " + "{{ $event->longitude }}");
                    
                    var map = L.map('public-map', {
                        zoomControl: false, // map mini disable zoom
                        scrollWheelZoom: false,
                        dragging: false
                    }).setView([lat, lon], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(map);

                    var marker = L.marker([lat, lon]).addTo(map);
                    
                    // Re-enable scroll wheel zoom if user clicks the map
                    map.on('click', function() {
                        if(map.scrollWheelZoom.enabled()) {
                            map.scrollWheelZoom.disable();
                            map.dragging.disable();
                        } else {
                            map.scrollWheelZoom.enable();
                            map.dragging.enable();
                        }
                    });

                    // Fix map visibility issues
                    setTimeout(function() {
                        map.invalidateSize();
                    }, 500);
                } catch (err) {
                    console.error("Map Error:", err);
                    document.getElementById('public-map').innerHTML = '<div style="display:flex; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#ef4444; background:#fef2f2; padding:20px; text-align:center;"><i class="fa-solid fa-triangle-exclamation mb-2" style="font-size:2rem;"></i><span>Peta tidak dapat dimuat: ' + err.message + '</span></div>';
                }
            }, 100);
            @endif
        });
    </script>
</body>
</html>