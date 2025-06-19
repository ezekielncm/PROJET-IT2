
// Vue : Voir un bailleur (manager/bailleur/voir.php)
// Variable attendue : $bailleur (objet Bailleur)
// Lien CSS spécifique bailleur
<?php require_once VIEW_PATH . 'manager/layout/header.php';?>
<div class="bailleurs-container">
    <h1 class="titre-page">Détail du bailleur</h1>
    <?php if (!empty($bailleur)): ?>
        <div class="bailleur-card">
            <div class="bailleur-info">
                <h2><?= htmlspecialchars($bailleur->getNom()) ?> <?= htmlspecialchars($bailleur->getPrenom()) ?></h2>
                <p><strong>Email :</strong> <?= htmlspecialchars($bailleur->getEmail()) ?></p>
                <p><strong>Téléphone :</strong> <?= htmlspecialchars($bailleur->getTelephone()) ?></p>
            </div>
            <div class="bailleur-actions">
                <a href="/manager/bailleur/editer?id_bailleur=<?= $bailleur->getId() ?>" class="btn btn-edit">Éditer</a>
                <a href="/manager/bailleur/liste" class="btn btn-back">Retour à la liste</a>
            </div>
        </div>
    <?php else: ?>
        <p>Bailleur introuvable.</p>
    <?php endif; ?>
</div>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>