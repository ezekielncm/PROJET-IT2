<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<link rel="stylesheet" href="/assets/css/public.css">

<main class="public-about-main">
    <section class="public-about-section">
        <div class="public-about-header">
            <h1 class="public-about-title">À propos de UrbanHome</h1>
            <p class="public-about-subtitle">Votre plateforme moderne de gestion immobilière</p>
        </div>
        <div class="public-about-content">
            <h2 class="public-about-heading">Notre mission</h2>
            <p class="public-about-text">
                UrbanHome simplifie la gestion, la location et la vente de biens immobiliers pour les clients, bailleurs, agents et managers. Notre plateforme propose une expérience fluide, sécurisée et adaptée à tous les profils.
            </p>
            <h2 class="public-about-heading">Fonctionnalités clés</h2>
            <ul class="public-about-list">
                <li>Gestion multi-utilisateurs (client, bailleur, agent, manager)</li>
                <li>Tableaux de bord personnalisés</li>
                <li>Messagerie interne et gestion des rendez-vous</li>
                <li>Ajout, modification et suivi des propriétés</li>
                <li>Sécurité renforcée et interface responsive</li>
            </ul>
            <h2 class="public-about-heading">Pourquoi choisir UrbanHome&nbsp;?</h2>
            <ul class="public-about-list">
                <li>Plateforme intuitive et moderne</li>
                <li>Support de tous les profils immobiliers</li>
                <li>Gestion centralisée et sécurisée</li>
                <li>Accès rapide à toutes les fonctionnalités depuis n'importe quel appareil</li>
            </ul>
            <p class="public-about-cta">
                <strong>UrbanHome</strong> – Simplifiez votre expérience immobilière dès aujourd'hui&nbsp;!
            </p>
            <?php if (isset($version) || isset($date)): ?>
                <div class="public-about-meta">
                    <?php if (isset($version)): ?>
                        <span class="public-about-meta-version">Version&nbsp;: <?= htmlspecialchars($version) ?></span>
                    <?php endif; ?>
                    <?php if (isset($date)): ?>
                        <span class="public-about-meta-date">&copy; <?= htmlspecialchars($date) ?> UrbanHome</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require_once FOOTER_PATH; ?>
