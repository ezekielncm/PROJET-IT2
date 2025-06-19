<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<link rel="stylesheet" href="/assets/css/manager.css">

<main class="manager-detail-container">
    <?php foreach ($proprietes as $propriete): ?>
        <article class="manager-detail-grid" aria-label="Détail propriété">
            <!-- Galerie d'images -->
            <section class="manager-detail-gallery" aria-label="Galerie photos">
                <figure class="manager-detail-gallery-main">
                    <img src="<?= ASSET_PATH ?>images/<?= htmlspecialchars($propriete['objet']->getImage1()) ?>" alt="Photo principale du bien" class="manager-detail-img-main" loading="lazy">
                </figure>
                <div class="manager-detail-gallery-side">
                    <?php if ($propriete['objet']->getImage2()): ?>
                        <img src="<?= ASSET_PATH ?>images/<?= htmlspecialchars($propriete['objet']->getImage2()) ?>" alt="Photo secondaire 1" class="manager-detail-img-side" loading="lazy">
                    <?php endif; ?>
                    <?php if ($propriete['objet']->getImage3()): ?>
                        <img src="<?= ASSET_PATH ?>images/<?= htmlspecialchars($propriete['objet']->getImage3()) ?>" alt="Photo secondaire 2" class="manager-detail-img-side" loading="lazy">
                    <?php endif; ?>
                </div>
            </section>

            <!-- Détails de la propriété -->
            <section class="manager-detail-infos">
                <div class="manager-detail-desc">
                    <h2 class="manager-detail-title">Description</h2>
                    <p><?= nl2br(htmlspecialchars($propriete['objet']->getDescription())) ?></p>
                    <ul class="manager-detail-list">
                        <?php if ($propriete['objet']->getOpt() == "Vente"): ?>
                            <li><span class="manager-label">Prix :</span> <b><?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> CFA</b></li>
                        <?php else: ?>
                            <li><span class="manager-label">Montant Mensuel :</span> <b><?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> CFA</b></li>
                        <?php endif; ?>
                        <li><span class="manager-label">Adresse :</span> <b><?= htmlspecialchars($propriete['objet']->getAdresse()) ?></b></li>
                        <li><span class="manager-label">Type :</span> <b><?= htmlspecialchars($propriete['type']->getlibele()) ?></b></li>
                        <li><span class="manager-label">Statut :</span> <b><?= htmlspecialchars($propriete['objet']->getEtat()) ?></b></li>
                        <li><span class="manager-label">Option :</span> <b><?= htmlspecialchars($propriete['objet']->getOpt()) ?></b></li>
                    </ul>
                </div>
                <!-- Actions -->
                <nav class="manager-detail-actions" aria-label="Actions propriété">
                    <a href="/client/propriete/rdv?id=<?= base64_encode($propriete['id']) ?>" class="manager-btn manager-btn-primary">Demander une visite</a>
                    <a href="/propriete" class="manager-btn manager-btn-danger">Retour</a>
                    <?php if (isset($_SESSION['id_client'])): ?>
                        <a href="/client/propriete?id=<?= base64_encode($propriete['id']) ?>" class="manager-btn manager-btn-success">Ajouter aux favoris</a>
                    <?php endif; ?>
                </nav>
            </section>
        </article>
    <?php endforeach; ?>
</main>

<?php require_once VIEW_PATH . 'public/layout/footer.php'; ?>