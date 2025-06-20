<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<main class="bailleurs-container" aria-label="Liste des bailleurs">
    <div class="manager-list-header">
        <h1 tabindex="0">Liste des bailleurs</h1>
        <a href="/manager/bailleur/ajouter" class="btn btn-add" title="Ajouter un bailleur">
            <span aria-hidden="true">&#43;</span> Ajouter un bailleur
        </a>
    </div>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="flash-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (!empty($bailleurs)): ?>
        <section class="bailleurs-list" aria-label="Cartes bailleurs">
            <?php foreach ($bailleurs as $bailleur): ?>
                <article class="bailleur-card" tabindex="0" aria-labelledby="bailleur-<?= htmlspecialchars($bailleur['id']) ?>-nom">
                    <div class="bailleur-info">
                        <h2 id="bailleur-<?= htmlspecialchars($bailleur['id']) ?>-nom" class="bailleur-<?= htmlspecialchars($bailleur['id']) ?>-nom">
                            <?= htmlspecialchars($bailleur['objet']->getNom()) ?> <?= htmlspecialchars($bailleur['objet']->getPrenom()) ?>
                        </h2>
                        <ul class="bailleur-details">
                            <li><span class="bailleur-label">Email :</span> <b><?= htmlspecialchars($bailleur['objet']->getEmail()) ?></b></li>
                            <li><span class="bailleur-label">Téléphone :</span> <b><?= htmlspecialchars($bailleur['objet']->getTelephone()) ?></b></li>
                        </ul>
                    </div>
                    <nav class="bailleur-actions" aria-label="Actions bailleur">
                        <a href="/manager/bailleur/voir?id_bailleur=<?= $bailleur['id'] ?>" class="btn btn-view" title="Voir le bailleur">Voir</a>
                        <a href="/manager/bailleur/editer?id_bailleur=<?= $bailleur['id'] ?>" class="btn btn-edit" title="Éditer le bailleur">Éditer</a>
                        <form method="POST" action="/manager/bailleur/supprimer" class="manager-inline-form" onsubmit="return confirm('Supprimer ce bailleur ?');" style="display:inline;">
                            <input type="hidden" name="id_bailleur" value="<?= $bailleur['id'] ?>">
                            <button type="submit" class="btn btn-delete" title="Supprimer le bailleur">
                                <span aria-hidden="true">&#128465;</span> <span class="sr-only">Supprimer</span>
                            </button>
                        </form>
                    </nav>
                </article>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <p class="manager-empty">Aucun bailleur trouvé.</p>
    <?php endif; ?>
    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="page-link<?= $i == $page ? ' active' : '' ?>">Page <?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</main>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
