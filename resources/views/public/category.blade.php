<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori: {{ $category->name }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* --- 1. Global Styles --- */
        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
            color: #334155;
            padding-top: 70px;
            overflow-x: hidden;
        }

        /* --- 2. Category Navigation (Glassmorphism + Horizontal Scroll) --- */
        .category-nav-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            padding: 1.2rem 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            position: sticky;
            top: 70px; /* Menempel di bawah Navbar Utama */
            z-index: 99;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);
        }

        .category-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 8px; /* Ruang untuk scrollbar */
            white-space: nowrap;
            -webkit-overflow-scrolling: touch; /* Smooth scroll di iOS */
        }

        /* Styling Scrollbar Modern */
        .category-scroll::-webkit-scrollbar {
            height: 4px;
        }
        .category-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .category-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .cat-pill {
            display: inline-flex;
            align-items: center;
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 2px solid transparent;
            color: #64748b;
            background: #f1f5f9;
        }

        .cat-pill:hover {
            color: #ef4444;
            background: #fee2e2;
            transform: translateY(-2px);
        }

        /* State Aktif */
        .cat-pill.active {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        /* --- 3. Page Header --- */
        .page-header {
            margin: 4rem 0 3.5rem;
            text-align: center;
        }
        
        .page-subtitle {
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 0.8rem;
        }

        .page-title {
            font-weight: 800;
            font-size: 2.8rem;
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        /* --- 4. Event Cards --- */
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

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            background-color: #f1f5f9;
        }
        
        .event-card:hover .card-img {
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

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            line-height: 1.4;
            color: #1e293b;
            transition: color 0.3s;
        }
        
        .event-card:hover .card-title {
            color: #ef4444;
        }

        .card-meta {
            font-size: 0.88rem;
            color: #64748b;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 10px;
            line-height: 1.4;
        }

        .card-meta i {
            margin-top: 3px;
        }

        /* --- 5. Empty State --- */
        .empty-state {
            background: white;
            border-radius: 24px;
            padding: 5rem 2rem;
            text-align: center;
            border: 2px dashed #cbd5e1;
            transition: 0.3s;
            margin-top: 2rem;
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
        
        .btn-empty {
            background: linear-gradient(135deg, #3b82f6, #4f46e5);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }
        
        .btn-empty:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
            color: white;
        }
    </style>
</head>
<body>

    @include('public.components.navbar')

    <!-- Kategori Nav (Sticky Top) -->
    <div class="category-nav-container">
        <div class="container">
            <div class="category-scroll">
                <a href="{{ route('home') }}" class="cat-pill">
                    Tampilkan Semua
                </a>

                @foreach ($categories as $cat)
                    <a href="{{ url('/kategori/'.$cat->slug) }}" 
                       class="cat-pill {{ $cat->id == $category->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container pb-5">
        
        <!-- Header Halaman -->
        <div class="page-header" data-aos="zoom-in" data-aos-duration="800">
            <div class="page-subtitle">Menelusuri Kategori</div>
            <h1 class="page-title">{{ $category->name }}</h1>
        </div>

        <div class="row g-4">
            @forelse ($events as $index => $event)
                <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 3) }}">
                    <a href="/kegiatan/{{ $event->id }}" class="event-card">
                        <div class="img-wrapper">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img" alt="{{ $event->title }}">
                                <div class="img-overlay"></div>
                            @else
                                <div class="card-img d-flex align-items-center justify-content-center text-muted">
                                    <i class="fa-regular fa-image fa-2x"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            
                            <div class="card-meta">
                                <i class="fa-regular fa-calendar" style="color:#6366f1;"></i>
                                <span>{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM Y') }}</span>
                            </div>
                            
                            <div class="card-meta" style="margin-top:auto;">
                                <i class="fa-solid fa-location-dot text-danger"></i>
                                <span>{{ $event->location }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12" data-aos="fade-up" data-aos-delay="100">
                    <div class="empty-state">
                        <i class="fa-solid fa-folder-open empty-icon"></i>
                        <h4 class="fw-bold text-slate-700">Belum Ada Agenda</h4>
                        <p class="text-muted mb-4">Kategori <strong>{{ $category->name }}</strong> belum memiliki jadwal kegiatan saat ini.</p>
                        <a href="{{ route('home') }}" class="btn-empty">
                            Lihat Semua Kegiatan
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi AOS Animation
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
                easing: 'ease-out-cubic',
            });
        });
    </script>
</body>
</html>