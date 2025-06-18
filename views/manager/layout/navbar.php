<div id="sidebarOverlay" class="sidebar-overlay"></div>
<nav id="sideNavbar" class="side-navbar manager-drawer">
    <div class="side-navbar-header">
        <span class="side-navbar-title">
            <img src="<?= ASSET_PATH ?>images/flavicon.png" alt="UrbanHome" style="height:32px;vertical-align:middle;"> Espace Manager
        </span>
        <button id="closeSidebar" class="close-sidebar" aria-label="Fermer le menu">&times;</button>
    </div>
    <ul class="side-navbar-list">
        <li><a href="/manager/accueil">Tableau de bord</a></li>
        <li><a href="/manager/users">Utilisateurs</a></li>
        <li><a href="/manager/properties">Propriétés</a></li>
        <li><a href="/manager/contracts">Contrats</a></li>
        <li><a href="/manager/payments">Paiements</a></li>
        <li><a href="/manager/profile">Profil</a></li>
        <li><a href="/manager/logout" style="color:#c00;">Déconnexion</a></li>
    </ul>
</nav>
