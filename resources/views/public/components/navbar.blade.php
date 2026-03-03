<style>
/* ===============================
   NAVBAR PRO DISKOMINFO STYLE
=================================*/

.glass-navbar {
    background: linear-gradient(135deg, #b91c1c, #ef4444);
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    transition: all 0.4s ease;
    padding: 12px 0;
}

/* Navbar saat scroll */
.glass-navbar.scrolled {
    background: linear-gradient(135deg, #991b1b, #dc2626);
    box-shadow: 0 6px 25px rgba(0,0,0,0.3);
    padding: 8px 0;
}

/* BRAND */
.navbar-brand img {
    transition: transform 0.3s ease;
}

.navbar-brand:hover img {
    transform: scale(1.05);
}

/* NAV LINK */
.navbar .nav-link {
    color: white !important;
    font-weight: 500;
    position: relative;
    margin: 0 8px;
    transition: 0.3s;
}

/* Animated underline */
.navbar .nav-link::after {
    content: "";
    position: absolute;
    width: 0%;
    height: 2px;
    bottom: -4px;
    left: 0;
    background-color: white;
    transition: width 0.3s ease;
}

.navbar .nav-link:hover::after {
    width: 100%;
}

.navbar .nav-link.active::after {
    width: 100%;
}

/* Dropdown */
.custom-dropdown-menu {
    border-radius: 12px;
    border: none;
    padding: 8px 0;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    animation: fadeIn 0.3s ease;
}

.custom-dropdown-menu .dropdown-item {
    padding: 10px 20px;
    transition: 0.3s;
}

.custom-dropdown-menu .dropdown-item:hover {
    background: #fee2e2;
    color: #b91c1c;
}

/* Animation */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to {opacity: 1; transform: translateY(0);}
}

/* Mobile Fix */
.navbar-toggler {
    border: none;
}

.navbar-toggler:focus {
    box-shadow: none;
}

/* ===============================
   REAL-TIME NOTIFICATION TOAST
=================================*/
.toast-container-fixed {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.custom-toast {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    width: 320px;
    border-left: 5px solid #4f46e5;
    overflow: hidden;
    transform: translateX(120%);
    opacity: 0;
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    display: flex;
    align-items: flex-start;
    padding: 16px;
    position: relative;
}

.custom-toast.show {
    transform: translateX(0);
    opacity: 1;
}

.toast-icon {
    font-size: 1.5rem;
    color: #4f46e5;
    margin-right: 14px;
    margin-top: 2px;
}

.toast-content {
    flex: 1;
}

.toast-title {
    font-weight: 700;
    font-size: 0.95rem;
    color: #1e293b;
    margin-bottom: 4px;
    line-height: 1.2;
}

.toast-message {
    font-size: 0.85rem;
    color: #64748b;
    line-height: 1.4;
    margin-bottom: 0;
}

.toast-close {
    position: absolute;
    top: 12px;
    right: 12px;
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 1rem;
    padding: 0;
    transition: color 0.2s;
}

.toast-close:hover {
    color: #ef4444;
}
</style>

<script>
window.addEventListener("scroll", function() {
    let navbar = document.querySelector(".glass-navbar");
    navbar.classList.toggle("scrolled", window.scrollY > 50);
});
</script>


<nav class="navbar navbar-expand-lg fixed-top glass-navbar">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logosmg.png') }}" 
                 alt="Diskominfo" 
                 style="height:45px; margin-right:10px;">
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- HOME -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <!-- KATEGORI -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Kategori
                    </a>

                    <ul class="dropdown-menu custom-dropdown-menu">

                        @isset($categories)
                            @forelse($categories as $cat)
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('category.show', $cat->slug) }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <span class="dropdown-item text-muted small">
                                        Belum ada kategori
                                    </span>
                                </li>
                            @endforelse
                        @else
                            <li>
                                <span class="dropdown-item text-muted small">
                                    Data tidak tersedia
                                </span>
                            </li>
                        @endisset

                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Toast Container -->
<div class="toast-container-fixed" id="toastContainer"></div>

<!-- Audio for notification (optional) -->
<audio id="notifSound" preload="auto">
    <!-- You can use a generic bell sound URL here if you want it to ring -->
    <source src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" type="audio/mpeg">
</audio>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Check Notification Periodically
    function checkNotifications() {
        fetch('/api/notifications/upcoming')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.event) {
                    showEventToast(data.event);
                }
            })
            .catch(err => console.error('Error fetching notifications:', err));
    }

    function showEventToast(event) {
        // Prevent showing the same notification multiple times in one session
        const notifiedEvents = JSON.parse(sessionStorage.getItem('notified_events') || '[]');
        if (notifiedEvents.includes(event.id)) {
            return; // Already notified
        }

        // Add to notified list
        notifiedEvents.push(event.id);
        sessionStorage.setItem('notified_events', JSON.stringify(notifiedEvents));

        // Build UI
        const toastId = 'toast-' + Date.now();
        const toastHtml = `
            <div class="custom-toast" id="${toastId}">
                <button class="toast-close" onclick="closeToast('${toastId}')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="toast-icon">
                    <i class="fa-solid fa-bell fa-shake"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${event.message}</div>
                    <p class="toast-message">
                        <strong>${event.title}</strong><br>
                        Waktu: ${event.time}
                    </p>
                </div>
            </div>
        `;

        const container = document.getElementById('toastContainer');
        container.insertAdjacentHTML('beforeend', toastHtml);

        const toastElement = document.getElementById(toastId);
        
        // Play sound
        const sound = document.getElementById('notifSound');
        if(sound) {
            sound.volume = 0.5;
            sound.play().catch(e => console.log('Audio auto-play prevented by browser'));
        }

        // Animate in
        setTimeout(() => {
            toastElement.classList.add('show');
        }, 100);

        // Auto close after 10 seconds
        setTimeout(() => {
            closeToast(toastId);
        }, 10000);
    }

    // Assign to window to be callable from string HTML
    window.closeToast = function(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('show');
            setTimeout(() => el.remove(), 500); // Wait for transition
        }
    }

    // Poll every 15 seconds (adjust interval as needed)
    setInterval(checkNotifications, 15000);
    
    // Check immediately on load
    setTimeout(checkNotifications, 2000);

});
</script>
