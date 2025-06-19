<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>

<div class="manager-dashboard">
    <div class="home-banner manager-banner">
        <h1>Tableau de bord manager <span class="urbanhome-logo">UrbanHome</span></h1>
        <p>Vue d’ensemble de l’activité de la plateforme : utilisateurs, propriétés, contrats, paiements, statistiques.</p>
    </div>
    <div class="manager-sections">
        <div class="manager-section">
            <h2 class="manager-gradient-title">Utilisateurs</h2>
            <p>Nombre total d’utilisateurs : <strong><?= $stats['users'] ?? '--' ?></strong></p>
            <a href="/manager/clients" class="btn-manager">Voir les clients</a>
            <a href="/manager/agents" class="btn-manager">Voir les agents</a>
            <a href="/manager/bailleurs" class="btn-manager">Voir les bailleurs</a>
        </div>
        <div class="manager-section">
            <h2 class="manager-gradient-title">Propriétés</h2>
            <p>Biens gérés : <strong><?= $stats['proprietes'] ?? '--' ?></strong></p>
            <a href="/manager/proprietes" class="btn-manager">Voir les propriétés</a>
        </div>
        <div class="manager-section">
            <h2 class="manager-gradient-title">Contrats & paiements</h2>
            <p>Contrats actifs : <strong><?= $stats['contrats'] ?? '--' ?></strong><br> Paiements enregistrés : <strong><?= $stats['paiements'] ?? '--' ?></strong></p>
            <a href="/manager/contrats" class="btn-manager">Voir les contrats</a>
            <a href="/manager/paiements" class="btn-manager btn-secondary">Voir les paiements</a>
        </div>
        <div class="manager-section">
            <h2 class="manager-gradient-title">Statistiques globales</h2>
            <p>Dernière connexion : <strong><?= $_SESSION['manager_last_login'] ?? '--' ?></strong></p>
            <a href="/manager/configuration" class="btn-manager btn-secondary">Configuration</a>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
