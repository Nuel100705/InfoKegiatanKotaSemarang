<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Kegiatan Terkini</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* --- 1. Global Styles --- */
        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
            color: #334155;
            padding-top: 70px;
            overflow-x: hidden;
        }
        
        /* --- Hero Section --- */
        .hero-banner {
            position: relative;
            background: linear-gradient(135deg, #ef4444 0%, #991b1b 100%);
            color: white;
            padding: 6rem 1rem 8rem;
            text-align: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            box-shadow: 0 15px 40px rgba(220, 38, 38, 0.2);
            margin-bottom: -60px;
            overflow: hidden;
            z-index: 1;
        }
        
        .hero-banner::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            opacity: 0.6;
            z-index: -1;
        }

        .hero-banner h1 {
            font-weight: 800;
            font-size: 2.8rem;
            margin-bottom: 1.2rem;
            text-shadow: 0 4px 15px rgba(0,0,0,0.2);
            letter-spacing: -0.5px;
        }

        .hero-banner p {
            font-size: 1.15rem;
            font-weight: 300;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* --- 2. Section Headers --- */
        .section-title {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(to right, #cbd5e1, transparent);
            margin-left: 15px;
            border-radius: 2px;
            opacity: 0.5;
        }

        .text-gradient-today {
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-tomorrow {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* --- 3. Event Cards --- */
        .event-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            border: 1px solid rgba(255,255,255,1);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #f1f5f9;
        }

        .img-wrapper {
            position: relative;
            height: 190px;
            overflow: hidden;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            background-color: #f1f5f9;
        }
        
        .event-card:hover .card-img-top {
            transform: scale(1.08);
        }
        
        .img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.6) 0%, transparent 60%);
            z-index: 1;
        }

        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
        }

        .event-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            line-height: 1.4;
            color: #1e293b;
            transition: color 0.3s;
        }
        
        .event-card:hover .event-title {
            color: #ef4444;
        }

        .event-meta {
            font-size: 0.88rem;
            color: #64748b;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: auto;
            line-height: 1.4;
        }

        .event-meta i {
            margin-top: 3px;
        }
        
        .badge-koko {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
            font-weight: 700;
            font-size: 0.75rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.4);
            padding: 6px 14px;
            border-radius: 12px;
        }

        /* --- 4. Empty State --- */
        .empty-state {
            background: white;
            border-radius: 24px;
            padding: 4rem 2rem;
            text-align: center;
            border: 2px dashed #cbd5e1;
            transition: 0.3s;
        }
        .empty-state:hover { border-color: #94a3b8; background: #f8fafc; }
        
        .empty-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* --- 5. Divider --- */
        .custom-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(203, 213, 225, 0.8), transparent);
            margin: 4rem 0;
        }

        /* --- 6. Date Filter UI --- */
        .date-filter-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin: 0 auto 3.5rem auto;
            max-width: 800px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            border: 1px solid rgba(255, 255, 255, 1);
            position: relative;
            z-index: 10;
        }

        .filter-label {
            font-weight: 700;
            font-size: 1.15rem;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .filter-icon-box {
            background: #fee2e2;
            color: #ef4444;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-size: 1.2rem;
        }

        .date-input-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-grow: 1;
            justify-content: flex-end;
        }

        .form-control-date {
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 12px 18px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            color: #1e293b;
            transition: all 0.3s ease;
            cursor: pointer;
            outline: none;
            width: 100%;
            max-width: 250px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }

        .form-control-date:focus, .form-control-date:hover {
            border-color: #ef4444;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .btn-clear-filter {
            background-color: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
            border-radius: 14px;
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-clear-filter:hover {
            background-color: #ef4444;
            color: white;
            border-color: #ef4444;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }
        
        @media (max-width: 768px) {
            .date-filter-box { flex-direction: column; align-items: flex-start; }
            .date-input-wrapper { width: 100%; justify-content: flex-start; flex-wrap: wrap; }
            .form-control-date { max-width: 100%; }
        }
    </style>
</head>
<body>

    @include('public.components.navbar')

    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="container" data-aos="zoom-in-up" data-aos-duration="800">
            <h1>Halo, Warga Semarang! 👋</h1>
            <p>Telusuri agenda, kegiatan pemerintahan, dan festival terbaru yang sedang hangat hari ini maupun esok hari.</p>
        </div>
    </div>

    <div class="container pb-5" style="position: relative; z-index: 5;">
        
        <!-- Date Filter Box -->
        <div class="date-filter-box" data-aos="fade-up" data-aos-delay="200">
            <h4 class="filter-label">
                <div class="filter-icon-box">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>
                Cari Tanggal Acara
            </h4>
            <form action="{{ route('home') }}" method="GET" class="date-input-wrapper m-0" id="filterForm">
                <input type="text" id="dateFilter" name="date_range" class="form-control-date" value="{{ request('date_range') }}" placeholder="Pilih Rentang Waktu..." readonly>
                @if(request('date_range'))
                    <a href="{{ route('home') }}" class="btn-clear-filter" title="Hapus Filter">
                        <i class="fa-solid fa-xmark"></i> Hapus
                    </a>
                @endif
            </form>
        </div>

        @if($isFiltered)
            <div class="row mb-5" data-aos="fade-up">
                <div class="col-12">
                    <h3 class="section-title">
                        <span class="text-gradient-today">
                            <i class="fa-solid fa-calendar-check"></i> Acara 
                            @if($startDate->isSameDay($endDate))
                                {{ $startDate->isoFormat('D MMMM Y') }}
                            @else
                                {{ $startDate->isoFormat('D MMM Y') }} - {{ $endDate->isoFormat('D MMM Y') }}
                            @endif
                        </span>
                    </h3>
                </div>
                
                <div class="row g-4">
                    @forelse($filteredEvents as $index => $event)
                        <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 3) }}">
                            <a href="/kegiatan/{{ $event->id }}" class="event-card">
                                <div class="badge-koko bg-white text-indigo-600" style="color:#4338ca;">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</div>
                                <div class="img-wrapper">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                                        <div class="img-overlay"></div>
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center text-muted">
                                            <i class="fa-regular fa-image fa-2x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="event-title">{{ $event->title }}</h5>
                                    <div class="event-meta">
                                        <i class="fa-solid fa-location-dot text-indigo-500" style="color:#6366f1;"></i> 
                                        <span>{{ $event->location }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12" data-aos="zoom-in">
                            <div class="empty-state">
                                <i class="fa-regular fa-folder-open empty-icon"></i>
                                <h5 class="fw-bold text-slate-700">Tidak ada agenda.</h5>
                                <p class="text-muted mb-0">Silakan pilih tanggal lain yang tersedia.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            <!-- Hari Ini -->
            <div class="row mb-5">
                <div class="col-12" data-aos="fade-right">
                    <h3 class="section-title">
                        <span class="text-gradient-today"><i class="fa-solid fa-fire text-danger"></i> Kegiatan Hari Ini</span>
                    </h3>
                </div>
            
                <div class="row g-4">
                    @forelse($todayEvents as $index => $event)
                        <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 3) }}">
                            <a href="/kegiatan/{{ $event->id }}" class="event-card">
                                <div class="badge-koko bg-danger text-white">HARI INI</div>
                                <div class="img-wrapper">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                                        <div class="img-overlay"></div>
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center text-muted">
                                            <i class="fa-regular fa-image fa-2x"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="event-title">{{ $event->title }}</h5>
                                    <div class="event-meta">
                                        <i class="fa-solid fa-location-dot text-danger"></i> 
                                        <span>{{ $event->location }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12" data-aos="zoom-in">
                            <div class="empty-state">
                                <i class="fa-regular fa-calendar-xmark empty-icon"></i>
                                <h5 class="fw-bold text-slate-700">Belum ada acara hari ini.</h5>
                                <p class="text-muted mb-0">Silakan cek jadwal untuk besok atau tanggal lainnya.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="custom-divider" data-aos="fade-in"></div>

            <!-- Besok -->
            <div class="row pb-4">
                <div class="col-12" data-aos="fade-right">
                    <h3 class="section-title">
                        <span class="text-gradient-tomorrow"><i class="fa-regular fa-clock text-primary"></i> Kegiatan Besok</span>
                    </h3>
                </div>

                <div class="row g-4">
                    @forelse($tomorrowEvents as $index => $event)
                        <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 3) }}">
                            <a href="/kegiatan/{{ $event->id }}" class="event-card">
                                <div class="badge-koko bg-primary text-white">BESOK</div>
                                <div class="img-wrapper">
                                    @if($event->image)
                                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                                        <div class="img-overlay"></div>
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center text-muted">
                                            <i class="fa-regular fa-image fa-2x"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <h5 class="event-title">{{ $event->title }}</h5>
                                    <div class="event-meta">
                                        <i class="fa-solid fa-location-dot text-primary"></i> 
                                        <span>{{ $event->location }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12" data-aos="zoom-in">
                            <div class="empty-state">
                                <i class="fa-solid fa-mug-hot empty-icon"></i>
                                <h5 class="fw-bold text-slate-700">Belum ada jadwal.</h5>
                                <p class="text-muted mb-0">Belum ada agenda yang dijadwalkan untuk esok hari.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    </div>

    @include('public.components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi library animasi AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
                easing: 'ease-out-cubic',
            });

            // Inisialisasi Flatpickr Range Mode
            flatpickr("#dateFilter", {
                mode: "range",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    // Hanya submit otomatis jika user sudah memilih kedua tanggal, atau click di single day
                    if (selectedDates.length === 2 || (selectedDates.length === 1 && instance.isOpen === false)) {
                        document.getElementById('filterForm').submit();
                    }
                },
                onClose: function(selectedDates, dateStr, instance) {
                    // Backup submit kalau window ditutup manual
                    if (dateStr && selectedDates.length > 0) {
                        document.getElementById('filterForm').submit();
                    }
                }
            });
        });
    </script>
</body>
</html>