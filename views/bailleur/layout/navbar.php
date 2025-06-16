<?php $encodedId = base64_encode($_SESSION['id']); ?>
<div id="sidebarOverlay" class="sidebar-overlay"></div>
<nav id="sideNavbar" class="side-navbar">
    <div class="side-navbar-header">
        <span class="side-navbar-title"><img src="<?= ASSET_PATH ?>images/flavicon.png" alt="UrbanHome" style="height:32px;vertical-align:middle;"> Espace Bailleur</span>
        <button id="closeSidebar" class="close-sidebar">&times;</button>
    </div>
    <ul class="side-navbar-list">
        <li><a href="/bailleur">Tableau de bord</a></li>
        <li><a href="/mes-proprietes">Mes Propriétés</a></li>
        <li><a href="/voir-mes-demande-de-visite">Demandes reçues</a></li>
        <li><a href="/bailleur/conversations">Mes conversations</a></li>
        <li><a href="Mon-profil?id=<?= $encodedId ?>">Profil</a></li>
        <li><a href="#" onclick="openLogoutModal()" class="logout-link">Déconnexion</a></li>
    </ul>
    <!-- Modal de confirmation -->
    <div id="logoutModal" class="logout-modal hidden">
        <div class="logout-modal-content">
            <h2>Confirmer la déconnexion</h2>
            <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
            <div class="logout-modal-actions">
                <button onclick="closeLogoutModal()" class="logout-cancel">Annuler</button>
                <a href="/logout" class="logout-confirm">Se déconnecter</a>
            </div>
        </div>
    </div>
</nav>
<script>
    // Drawer menu
    const burger = document.getElementById('burgerMenu');
    const sidebar = document.getElementById('sideNavbar');
    const overlay = document.getElementById('sidebarOverlay');
    const closeBtn = document.getElementById('closeSidebar');
    if(burger && sidebar && overlay && closeBtn) {
        burger.onclick = () => { sidebar.classList.add('open'); overlay.classList.add('show'); };
        closeBtn.onclick = () => { sidebar.classList.remove('open'); overlay.classList.remove('show'); };
        overlay.onclick = () => { sidebar.classList.remove('open'); overlay.classList.remove('show'); };
    }
    // Logout modal
    function openLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
    }
    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
    }
</script>