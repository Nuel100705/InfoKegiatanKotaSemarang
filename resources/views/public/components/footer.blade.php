<footer class="public-footer">
    <div class="container pb-4 pt-5">
        <div class="row g-4">
            <!-- Brand & Description -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h4 class="footer-title">
                    <i class="fa-solid fa-map-location-dot me-2 text-danger"></i> Info Kegiatan
                </h4>
                <p class="footer-desc mt-3">
                    Portal informasi resmi acara, festival, dan kegiatan pemerintahan terkini di lingkup Kota Semarang. 
                    Telusuri agenda hari ini, esok, maupun bulan depan agar selalu tahu apa yang sedang terjadi di kotamu!
                </p>
                <div class="social-links mt-4">
                    <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <!-- Tautan Cepat -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-heading">Tautan Cepat</h5>
                <ul class="footer-links list-unstyled mt-3">
                    <li><a href="/">Beranda Utama</a></li>
                    <li><a href="/">Seluruh Acara</a></li>
                    <li><a href="/">Kategori Acara</a></li>
                    <li><a href="#">Tentang Portal</a></li>
                </ul>
            </div>

            <!-- Bantuan -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-heading">Bantuan Pusat</h5>
                <ul class="footer-links list-unstyled mt-3">
                    <li><a href="#">FAQ & Bantuan</a></li>
                    <li><a href="#">Syarat Penggunaan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="/admin/login">Area Admin</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="footer-heading">Pusat Informasi</h5>
                <ul class="footer-contact list-unstyled mt-3">
                    <li>
                        <i class="fa-solid fa-location-dot mt-1"></i> 
                        <span>Gedung Balaikota Semarang<br>Jl. Pemuda No. 148, Sekayu, Kec. Semarang Tengah, Kota Semarang 50132</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope mt-1"></i> 
                        <span>info@kegiatankota.smg.go.id</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone mt-1"></i> 
                        <span>(024) 3513366 - Call Center</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom text-center mt-5 pt-4">
            <p class="mb-0 opacity-75">
                &copy; {{ date('Y') }} Portal Info Kegiatan Kota Semarang. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<style>
    /* Styling Footer */
    .public-footer {
        background-color: #111827; /* Mode gelap senada */
        color: #f8fafc;
        border-top: 5px solid #ef4444; /* Garis aksen Merah Semarang */
        margin-top: 5rem;
        position: relative;
        z-index: 10;
        font-family: 'Poppins', sans-serif;
    }

    .footer-title {
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #ffffff;
        display: flex;
        align-items: center;
    }

    .footer-title i {
        background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .footer-desc {
        color: #94a3b8;
        font-size: 0.95rem;
        line-height: 1.7;
    }

    .footer-heading {
        color: #ffffff;
        font-weight: 600;
        font-size: 1.15rem;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .footer-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 30px;
        height: 3px;
        background-color: #ef4444;
        border-radius: 2px;
    }

    .footer-links {
        padding-left: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .footer-links a::before {
        content: '\f105'; /* FontAwesome angle-right */
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-right: 8px;
        font-size: 0.8rem;
        color: #ef4444;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: #ffffff;
        transform: translateX(5px);
    }
    
    .footer-links a:hover::before {
        opacity: 1;
        transform: translateX(0);
    }

    .footer-contact li {
        color: #94a3b8;
        margin-bottom: 16px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.95rem;
    }

    .footer-contact i {
        color: #ef4444;
        font-size: 1.2rem;
        width: 20px;
        text-align: center;
    }

    .social-links {
        display: flex;
        gap: 12px;
    }

    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.05);
        color: #cbd5e1;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .social-icon:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 0.9rem;
        color: #64748b;
    }
</style>
