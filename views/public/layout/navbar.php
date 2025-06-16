<div id="sidebarOverlay" class="sidebar-overlay"></div>
<nav id="sideNavbar" class="side-navbar">
    <div class="side-navbar-header">
        <span class="side-navbar-title"><img src="<?= ASSET_PATH ?>images/flavicon.png" alt="UrbanHome" style="height:32px;vertical-align:middle;"> UrbanHome</span>
        <button id="closeSidebar" class="close-sidebar">&times;</button>
    </div>
    <ul class="side-navbar-list">
        <li><a href="/">Accueil</a></li>
        <li><a href="/propriete">Propriété</a></li>
        <li class="side-dropdown">
            <a href="#" class="side-dropbtn">Espace <span class="chevron">&#8250;</span></a>
            <ul class="side-dropdown-content">
                <li><a href="/client">Espace Client</a></li>
                <li><a href="/bailleur">Espace Bailleur</a></li>
                <li><a href="/manager">Espace Manager</a></li>
                <li><a href="/connexion-agent">Espace Agent</a></li>
            </ul>
        </li>
        <li><a href="/about">A propos de nous</a></li>
        <li><a href="/contact">Nous Contacter</a></li>
    </ul>
</nav>
