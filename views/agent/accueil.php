<?php require_once VIEW_PATH . 'agent/layout/header.php'; ?>

<?php if (isset($_SESSION['id_agent'])) : ?>
    <main class="agent-dashboard-container">
        <div class="agent-dashboard-header">
            <h1 class="agent-dashboard-title">Bienvenue, <?= htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['prenom'] ?? 'Agent') ?> 👋</h1>
            <p class="agent-dashboard-subtitle">Voici votre tableau de bord.</p>
        </div>

        <?php if (isset($_SESSION['success_maj'])) : ?>
            <div id="flashMessage" class="agent-flash-message agent-flash-success">
                <?= htmlspecialchars($_SESSION['success_maj']) ?>
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.getElementById('flashMessage');
                    if (msg) msg.style.display = 'none';
                }, 5000);
            </script>
            <?php unset($_SESSION['success_maj']); ?>
        <?php endif; ?>

        <section class="agent-dashboard-stats">
            <div class="agent-dashboard-card agent-dashboard-card-red">
                <h3>Demandes en attente</h3>
                <p><?= $nb_demandes ?? 0 ?></p>
            </div>
            <div class="agent-dashboard-card agent-dashboard-card-blue">
                <h3>Clients attribués</h3>
                <p><?= $nb_clients ?? 0 ?></p>
            </div>
            <div class="agent-dashboard-card agent-dashboard-card-green">
                <h3>Rendez-vous planifiés</h3>
                <p><?= $nb_rdv ?? 0 ?></p>
            </div>
        </section>

        <section class="agent-dashboard-actions">
            <h2>Actions rapides</h2>
            <div class="agent-dashboard-actions-list">
                <a href="/demandes-validation" class="agent-btn agent-btn-yellow">Voir les demandes à valider</a>
                <a href="/clients-attribues" class="agent-btn agent-btn-blue">Liste des clients</a>
                <a href="/clients-rdv-bailleurs" class="agent-btn agent-btn-green">Voir les rendez-vous</a>
                <a href="/mon-profile" class="agent-btn agent-btn-gray">Mon profil</a>
            </div>
            <p class="agent-dashboard-warning">⚠️ Modification du profil soumise à l'approbation du manager.</p>
        </section>
    </main>

<?php else : ?>
    <main class="agent-error-container">
        <div class="agent-error-box">
            <h2 class="agent-error-title">Erreur</h2>
            <p class="agent-error-text">Vous devez être connecté pour accéder à cette page.</p>
            <a href="/agent" class="agent-error-link">Se connecter</a>
        </div>
    </main>
<?php endif; ?>

<?php require_once VIEW_PATH . 'agent/layout/footer.php'; ?>