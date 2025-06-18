<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<link rel="stylesheet" href="/assets/css/manager.css">

<div class="manager-detail-container">
    <?php foreach ($proprietes as $propriete): ?>
        <div class="manager-detail-grid">
            <!-- Galerie d'images -->
            <div class="manager-detail-gallery">
                <div class="manager-detail-gallery-main">
                    <img src="<?= ASSET_PATH ?>images/<?= htmlspecialchars($propriete['objet']->getImage1()) ?>" alt="Image 1" class="manager-detail-img-main" loading="lazy">
                </div>
                <div class="manager-detail-gallery-side">
                    <img src="<?= ASSET_PATH ?>images/<?= htmlspecialchars($propriete['objet']->getImage2()) ?>" alt="Image 2" class="manager-detail-img-side" loading="lazy">
                    <img src="<?= ASSET_PATH ?>images/<?= htmlspecialchars($propriete['objet']->getImage3()) ?>" alt="Image 3" class="manager-detail-img-side" loading="lazy">
                </div>
            </div>

            <!-- Détails de la propriété -->
            <div class="manager-detail-infos">
                <div class="manager-detail-desc">
                    <p><?= htmlspecialchars($propriete['objet']->getDescription()) ?></p>
                    <?php if ($propriete['objet']->getOpt() == "Vente"): ?>
                        <p><strong>Prix :</strong> <?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> CFA</p>
                    <?php else: ?>
                        <p><strong>Montant Mensuel :</strong> <?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> CFA</p>
                    <?php endif; ?>
                    <p><strong>Adresse :</strong> <?= htmlspecialchars($propriete['objet']->getAdresse()) ?></p>
                    <p><strong>Type :</strong> <?= htmlspecialchars($propriete['type']->getlibele()) ?></p>
                    <p><strong>Statut :</strong> <?= htmlspecialchars($propriete['objet']->getEtat()) ?></p>
                    <p><strong>Option :</strong> <?= htmlspecialchars($propriete['objet']->getOpt()) ?></p>
                </div>
                <!-- Actions -->
                <div class="manager-detail-actions">
                    <a href="/client/propriete/rdv?id=<?= base64_encode($propriete['id']) ?>" class="manager-btn manager-btn-primary">Demander une visite</a>
                    <a href="/propriete" class="manager-btn manager-btn-danger">Retour</a>
                    <?php if (isset($_SESSION['id_client'])): ?>
                        <a href="/client/propriete?id=<?= base64_encode($propriete['id']) ?>" class="manager-btn manager-btn-success">Ajouter aux favoris</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once VIEW_PATH . 'public/layout/footer.php'; ?>