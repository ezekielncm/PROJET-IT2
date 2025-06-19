<?php
// Vue : Liste des bailleurs (manager/bailleur/liste.php)
// Accessible depuis le dashboard manager
// Variables attendues : $bailleurs (tableau d'objets Bailleurs), $page, $totalPages
require_once VIEW_PATH . 'manager/layout/header.php';
?>
<div class="bailleurs-container">
    <h1 class="titre-page">Liste des bailleurs</h1>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="flash-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <div class="bailleurs-list">
        <?php if (!empty($bailleurs)): ?>
            <?php foreach ($bailleurs as $bailleur): ?>
                <div class="bailleur-card">
                    <div class="bailleur-info">
                        <h2><?= htmlspecialchars($bailleur->getNom()) ?> <?= htmlspecialchars($bailleur->getPrenom()) ?></h2>
                        <p><strong>Email :</strong> <?= htmlspecialchars($bailleur->getEmail()) ?></p>
                        <p><strong>Téléphone :</strong> <?= htmlspecialchars($bailleur->getTelephone()) ?></p>
                    </div>
                    <div class="bailleur-actions">
                        <a href="/manager/bailleur/voir?id_bailleur=<?= $bailleur->getId() ?>" class="btn btn-view">Voir</a>
                        <a href="/manager/bailleur/editer?id_bailleur=<?= $bailleur->getId() ?>" class="btn btn-edit">Éditer</a>
                        <form method="POST" action="/manager/bailleur/supprimer" onsubmit="return confirm('Supprimer ce bailleur ?');" style="display:inline;">
                            <input type="hidden" name="id_bailleur" value="<?= $bailleur->getId() ?>">
                            <button type="submit" class="btn btn-delete">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun bailleur trouvé.</p>
        <?php endif; ?>
    </div>
    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="page-link<?= $i == $page ? ' active' : '' ?>">Page <?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
    <a href="/manager/bailleur/ajouter" class="btn btn-add">Ajouter un bailleur</a>
</div>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>