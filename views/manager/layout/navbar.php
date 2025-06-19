<div id="sidebarOverlay" class="sidebar-overlay"></div>
<nav id="sideNavbar" class="side-navbar manager-drawer">
    <div class="side-navbar-header">
        <span class="side-navbar-title">
            <img src="<?= ASSET_PATH ?>images/flavicon.png" alt="UrbanHome" style="height:32px;vertical-align:middle;"> Espace Manager
        </span>
        <button id="closeSidebar" class="close-sidebar" aria-label="Fermer le menu">&times;</button>
    </div>
    <ul class="side-navbar-list">
        <li><a href="/manager/dashboard">Tableau de bord</a></li>
        <li class="side-dropdown">
            <a href="#" class="side-dropbtn">Utilisateurs <span class="chevron">&#8250;</span></a>
            <ul class="side-dropdown-content">
                <li><a href="/manager/clients">Client</a></li>
                <li><a href="/manager/bailleurs">Bailleur</a></li>
                <li><a href="/manager/agents">Agent</a></li>
            </ul>
        </li>
        <li><a href="/manager/proprietes">Propriétés</a></li>
        <li><a href="/manager/contrats">Contrats</a></li>
        <li><a href="/manager/paiments">Paiements</a></li>
        <li><a href="/manager/profile">Profil</a></li>
        <li><a href="/manager/logout" style="color:#c00;">Déconnexion</a></li>
    </ul>
</nav>
