<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Info Kegiatan</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #ef4444;
            --primary-hover: #dc2626;
            --sidebar-bg: #111827;
            --sidebar-hover: rgba(255,255,255,0.08);
            --bg-body: #f1f5f9;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: #f8fafc;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 20px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 25px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .sidebar-header i { font-size: 1.5rem; color: #f87171; }
        .sidebar-header h5 { margin: 0; font-weight: 700; font-size: 1.1rem; letter-spacing: 0.5px; }

        .sidebar-menu {
            padding: 20px 15px;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-menu .menu-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            font-weight: 700;
            margin: 10px 0 10px 10px;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 6px;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar a i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--sidebar-hover);
            color: #fff;
            transform: translateX(5px);
        }
        .sidebar a:hover i { transform: scale(1.1); color: #f87171; }
        .sidebar a.active { background: linear-gradient(135deg, var(--primary), #b91c1c); box-shadow: 0 4px 15px rgba(239,68,68,0.3); }
        .sidebar a.active i { color: #fff; }
        
        .sidebar-footer { padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); }
        .btn-logout { width: 100%; background: rgba(239,68,68,0.1); color: #f87171; border: none; padding: 10px; border-radius: 8px; font-weight: 600; transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; }
        .btn-logout:hover { background: #ef4444; color: white; }

        /* --- MAIN CONTENT --- */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* TOPBAR */
        .topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .topbar-title { margin: 0; font-weight: 700; font-size: 1.3rem; color: var(--text-dark); }
        
        .admin-profile { display: flex; align-items: center; gap: 12px; background: white; padding: 6px 16px 6px 6px; border-radius: 50px; border: 1px solid #e2e8f0; cursor: pointer; transition: 0.2s; }
        .admin-profile:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-color: #cbd5e1; }
        .profile-avatar { width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary), #991b1b); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; }
        .profile-name { font-weight: 600; font-size: 0.9rem; color: var(--text-dark); }

        /* CONTENT AREA */
        .content-area {
            padding: 30px;
            flex: 1;
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* REUSABLE CARDS */
        .admin-card {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        /* TABLES */
        .table-custom { border-collapse: separate; border-spacing: 0 8px; margin-top: -8px; }
        .table-custom thead th { border: none; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 15px; background: transparent; }
        .table-custom tbody tr { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 10px; transition: transform 0.2s, box-shadow 0.2s; }
        .table-custom tbody tr:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); z-index: 1; position: relative; }
        .table-custom tbody td { border: none; padding: 16px 15px; vertical-align: middle; color: var(--text-dark); font-size: 0.95rem; }
        .table-custom tbody td:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        .table-custom tbody td:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }

        /* BUTTONS */
        .btn-primary-custom { background: linear-gradient(135deg, var(--primary), #b91c1c); border: none; color: white; padding: 10px 20px; border-radius: 10px; font-weight: 600; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(239,68,68,0.3); color: white; }
        .btn-action { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; border: none; transition: 0.2s; color: white; text-decoration: none; }
        .btn-action.edit { background: rgba(239,68,68,0.1); color: #ef4444; }
        .btn-action.edit:hover { background: #ef4444; color: white; }
        .btn-action.delete { background: rgba(153,27,27,0.1); color: #991b1b; }
        .btn-action.delete:hover { background: #991b1b; color: white; }

        /* FORMS */
        .form-control, .form-select { border-radius: 10px; padding: 12px 15px; border: 1px solid #cbd5e1; font-size: 0.95rem; transition: 0.2s; background: #f8fafc; }
        .form-control:focus, .form-select:focus { background: white; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(239,68,68,0.1); }
        .form-label { font-weight: 600; color: #334155; margin-bottom: 8px; font-size: 0.9rem; }

        /* RESPONSIVE */
        @media(max-width: 992px){
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .mobile-toggle { display: block !important; }
        }
        .mobile-toggle { display: none; font-size: 1.5rem; color: var(--text-dark); cursor: pointer; border: none; background: transparent; }
    </style>
    @yield('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div style="background: white; padding: 5px; border-radius: 8px;"><i class="fa-solid fa-shapes"></i></div>
        <h5>AdminPanel</h5>
    </div>
    
    <div class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>
        <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
            <i class="fa-solid fa-tags"></i> Kategori
        </a>
        <a href="{{ route('events.index') }}" class="{{ request()->is('admin/events*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-star"></i> Kegiatan Event
        </a>

        <div class="menu-label mt-4">Pengaturan</div>
        <a href="{{ route('admin.profile') }}" class="{{ request()->is('admin/profile') ? 'active' : '' }}">
            <i class="fa-solid fa-user-gear"></i> Profil Admin
        </a>
    </div>

    <div class="sidebar-footer">
        <a href="/logout" class="btn-logout">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
        </a>
    </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
    <!-- TOPBAR -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <h4 class="topbar-title">@yield('title', 'Dashboard')</h4>
        </div>
        
        <div class="admin-profile" onclick="window.location='{{ route('admin.profile') }}'">
            <div class="profile-avatar"><i class="fa-regular fa-user"></i></div>
            <div class="profile-name">Halo, Admin</div>
        </div>
    </div>

    <!-- CONTENT AREA -->
    <div class="content-area">

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfigurasi Toast Custom (SweetAlert)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        background: '#ffffff',
        color: '#1e293b',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: "{!! session('success') !!}"
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{!! session('error') !!}",
            confirmButtonColor: '#ef4444'
        });
    @endif

    // Fungsi Konfirmasi Hapus Data
    function confirmDelete(event, form) {
        event.preventDefault();
        let title = form.getAttribute('data-confirm-title') || 'Yakin hapus data?';
        let text = form.getAttribute('data-confirm-text') || 'Data yang dihapus tidak bisa dikembalikan!';
        
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@yield('scripts')
</body>
</html>
