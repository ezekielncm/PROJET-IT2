// Permettre l'actualisation automatique de toutes les pages (auto-refresh)
// Actualise la page toutes les 5 minutes (300 000 ms)
setInterval(function() {
    window.location.reload();
}, 300000);

// Menu burger responsive
window.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('burgerMenu');
    const nav = document.getElementById('mainNavbar');
    if (burger && nav) {
        burger.addEventListener('click', function() {
            nav.classList.toggle('active');
            burger.classList.toggle('open');
        });
    }
});

// Sidebar responsive pour l'espace bailleur
window.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    if (sidebar && toggle) {
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('hidden');
        });
    }
});

// Sidebar responsive pour l'espace client
window.addEventListener('DOMContentLoaded', function() {
    const sidebarClient = document.getElementById('sidebarClient');
    const toggleClient = document.getElementById('sidebarToggleClient');
    if (sidebarClient && toggleClient) {
        toggleClient.addEventListener('click', function() {
            sidebarClient.classList.toggle('hidden');
        });
    }
});

// Sidebar responsive pour l'espace manager
window.addEventListener('DOMContentLoaded', function() {
    const sidebarManager = document.getElementById('sidebarManager');
    const toggleManager = document.getElementById('sidebarToggleManager');
    if (sidebarManager && toggleManager) {
        toggleManager.addEventListener('click', function() {
            sidebarManager.classList.toggle('hidden');
        });
    }
});

// Menu latéral (side-navbar) moderne
window.addEventListener('DOMContentLoaded', function() {
    const burger = document.getElementById('burgerMenu');
    const sidebar = document.getElementById('sideNavbar');
    const overlay = document.getElementById('sidebarOverlay');
    const closeBtn = document.getElementById('closeSidebar');
    const dropdown = document.querySelector('.side-dropdown');
    const dropBtn = document.querySelector('.side-dropbtn');

    function openSidebar() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    if (burger) burger.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // Accordéon pour le sous-menu Espace
    if (dropdown && dropBtn) {
        dropBtn.addEventListener('click', function(e) {
            e.preventDefault();
            dropdown.classList.toggle('open');
        });
    }
});
