
<?php require_once VIEW_PATH . '/bailleur/layout/header.php'; ?>

    <?php if (isset($_SESSION['id'])) : ?>
        <main class="bailleur-dashboard-container">
            <section class="bailleur-dashboard-header">
                <h1>Bienvenue, <?= $_SESSION['nom'] ?? 'Bailleur' ?> 👋</h1>
                <p>Voici votre tableau de bord.</p>
            </section>
            <?php if (isset($_SESSION['success_maj']) ) : ?>
                <div id="flashMessage" class="bailleur-flash-message">
                    <?= htmlspecialchars($_SESSION['success_maj']) ?>
                </div>
                <script>
                    setTimeout(function () {
                        const msg = document.getElementById('flashMessage');
                        if (msg) { msg.classList.add('bailleur-flash-out'); setTimeout(()=>msg.remove(), 500); }
                    }, 3500);
                </script>
                <?php unset($_SESSION['success_maj']); ?>
            <?php endif; ?>

            <div class="bailleur-dashboard-cards">
                <div class="bailleur-dashboard-card">
                    <h3>Nombre de propriétés</h3>
                    <p class="bailleur-dashboard-nb bailleur-blue"><?=  isset($nbreProprietes)?$nbreProprietes : 0 ?></p>
                </div>
                <div class="bailleur-dashboard-card">
                    <h3>Rendez-Vous</h3>
                    <p class="bailleur-dashboard-nb bailleur-green"><?= isset($rdv_) ? $rdv_ : 0 ?></p>
                </div>
                <div class="bailleur-dashboard-card">
                    <h3>Ventes-Locations</h3>
                    <p class="bailleur-dashboard-nb bailleur-indigo"><?= isset($nb_ventes) ? $nb_ventes : 0 ?></p>
                </div>
                <div class="bailleur-dashboard-card">
                    <h3>Montant total engagé</h3>
                    <p class="bailleur-dashboard-nb bailleur-indigo">45M CFA</p>
                </div>
            </div>

            <section class="bailleur-dashboard-actions">
                <h2>Actions rapides</h2>
                <div class="bailleur-dashboard-actions-list">
                    <?php $encodedId = base64_encode($_SESSION['id']); ?>
                    <a href="/nouvelle-propiete?id=<?= $encodedId ?>" class="bailleur-btn bailleur-btn-blue">Ajouter une propriété</a>
                    <a href="/voir-mes-demande-de-visite" class="bailleur-btn bailleur-btn-green">Voir les demandes</a>
                    <a href="Mon-profil?id=<?= $encodedId?>" class="bailleur-btn bailleur-btn-grey">Mon profil</a>
                    <a href="/ventes-locations" class="bailleur-btn bailleur-btn-grey">Ventes - Locations</a>
                </div>
            </section>
        </main>
    <?php else : ?>
        <div class="bailleur-error-container">
            <div class="bailleur-error-card">
                <h2>Erreur</h2>
                <p>Vous devez être connecté pour accéder à cette page.</p>
                <a href="/bailleur">Se connecter</a>
            </div>
        </div>
    <?php endif; ?>

<?php require_once VIEW_PATH . 'bailleur/layout/footer.php'; ?>