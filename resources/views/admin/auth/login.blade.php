<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Info Kegiatan Semarang</title>
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ef4444 0%, #7f1d1d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Abstract Background Decor */
        .bg-shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0));
            border-radius: 50%;
            backdrop-filter: blur(5px);
            z-index: 0;
            animation: moveShape 15s infinite alternate ease-in-out;
        }
        .shape1 { width: 400px; height: 400px; top: -100px; left: -100px; }
        .shape2 { width: 300px; height: 300px; bottom: -50px; right: -50px; animation-duration: 20s; animation-direction: alternate-reverse; }
        
        @keyframes moveShape {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(50px, 50px) rotate(45deg); }
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            z-index: 10;
            padding: 2.5rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            color: white;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
            transform: rotate(-10deg);
        }

        .login-title {
            font-weight: 800;
            font-size: 1.8rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Input Fields */
        .form-floating > label {
            padding-left: 1.25rem;
            color: #94a3b8;
        }

        .form-control {
            border-radius: 12px;
            padding: 1rem 1.25rem;
            border: 2px solid #e2e8f0;
            height: auto;
            font-size: 1rem;
            color: #1e293b;
            background-color: #f8fafc;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            background-color: white;
        }

        .input-group-text {
            background-color: transparent;
            border: 2px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .form-control:focus + .input-group-text {
            border-color: #ef4444;
            color: #ef4444;
        }
        
        .input-group .form-control {
            border-right: none;
            border-radius: 12px 0 0 12px;
        }

        /* Login Button */
        .btn-login {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.3);
            width: 100%;
            margin-top: 1.5rem;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(220, 38, 38, 0.4);
            color: white;
        }

        .alert-modern {
            border-radius: 12px;
            border: none;
            background: #fee2e2;
            color: #b91c1c;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Copyright */
        .copyright {
            position: absolute;
            bottom: 2rem;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            text-align: center;
            width: 100%;
            z-index: 10;
        }

    </style>
</head>
<body>

    <!-- Background Decoration -->
    <div class="bg-shape shape1"></div>
    <div class="bg-shape shape2"></div>

    <div class="container d-flex justify-content-center">
        <div class="login-card" data-aos="zoom-in-up" data-aos-duration="1000">
            
            <div class="login-header">
                <div class="login-icon">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <h2 class="login-title">Panel Admin</h2>
                <p class="login-subtitle">Masuk untuk mengelola agenda kegiatan</p>
            </div>

            @if(session('error'))
                <div class="alert alert-modern mb-4" data-aos="shake" data-aos-delay="300">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/admin/login">
                @csrf
                
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="name@example.com" required autocomplete="email">
                    <label for="floatingEmail"><i class="fa-regular fa-envelope me-2"></i> Alamat Email</label>
                </div>

                <div class="input-group mb-2" style="position: relative;">
                    <div class="form-floating flex-grow-1">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required style="border-right: none; border-radius: 12px 0 0 12px;">
                        <label for="floatingPassword"><i class="fa-solid fa-lock me-2"></i> Kata Sandi</label>
                    </div>
                    <span class="input-group-text" id="togglePassword" title="Tampilkan/Sembunyikan Sandi" style="border-radius: 0 12px 12px 0; background: transparent;">
                        <i class="fa-regular fa-eye text-muted"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Sekarang
                </button>
            </form>

        </div>
    </div>

    <div class="copyright">
        &copy; {{ date('Y') }} Info Kegiatan Semarang. Akses Terbatas.
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi Inisialisasi
            AOS.init({
                once: true,
                offset: 0
            });

            // Toggle Password Visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('floatingPassword');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle Icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>
