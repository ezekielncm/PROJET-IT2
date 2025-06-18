<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>

<div class="manager-dashboard">
    <div class="home-banner manager-banner">
        <h1>Bienvenue sur votre espace manager <span class="urbanhome-logo">UrbanHome</span></h1>
        <p>Gérez les utilisateurs, les propriétés et suivez l’activité de la plateforme.</p>
    </div>
    <div class="home-sections manager-sections">
        <div class="home-section manager-section">
            <h2>Gestion des clients</h2>
            <p>Consultez, assignez et gérez les comptes clients.</p>
            <a href="/manager/clients" class="btn-manager">Voir les clients</a>
        </div>
        <div class="home-section manager-section">
            <h2>Propriétés</h2>
            <p>Supervisez l’ensemble des biens immobiliers de la plateforme.</p>
            <a href="/manager/proprietes" class="btn-manager">Voir les propriétés</a>
        </div>
        <div class="home-section manager-section">
            <h2>Contrats & paiements</h2>
            <p>Suivez les contrats, paiements et statistiques globales.</p>
            <a href="/manager/contrats" class="btn-manager">Voir les contrats</a>
            <a href="/manager/paiements" class="btn-manager btn-secondary">Voir les paiements</a>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>