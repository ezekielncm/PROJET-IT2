<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<main class="paiements-container" aria-label="Liste des paiements">
    <div class="manager-list-header">
        <h1 tabindex="0">Liste des paiements</h1>
        <a href="/manager/paiement/ajouter" class="btn btn-add" title="Ajouter un paiement">
            <span aria-hidden="true">&#43;</span> Ajouter un paiement
        </a>
    </div>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="flash-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (!empty($paiements)): ?>
        <section class="paiements-list" aria-label="Cartes paiements">
            <?php foreach ($paiements as $paiement): ?>
                <article class="paiement-card" tabindex="0" aria-labelledby="paiement-<?= htmlspecialchars($paiement['id']) ?>-ref">
                    <div class="paiement-info">
                        <h2 id="paiement-<?= htmlspecialchars($paiement['id']) ?>-ref" class="paiement-ref">
                            Réf. : <?= htmlspecialchars($paiement['id']) ?>
                        </h2>
                        <ul class="paiement-details">
                            <li><span class="paiement-label">Montant :</span> <b><?= htmlspecialchars($paiement['objet']->getMontant()) ?> F</b></li>
                            <li><span class="paiement-label">Date :</span> <b><?= htmlspecialchars($paiement['objet']->getDate_paiement()) ?></b></li>
                            <li><span class="paiement-label">Type :</span> <b><?= htmlspecialchars($paiement['objet']->getId_type_paiement()) ?></b></li>
                            <li><span class="paiement-label">Client :</span> <b><?= htmlspecialchars($paiement['client_nom']) ?></b></li>
                        </ul>
                    </div>
                    <nav class="paiement-actions" aria-label="Actions paiement">
                        <a href="/manager/paiement/voir?id=<?= base64_encode($paiement['id']) ?>" class="btn btn-view" title="Voir les détails du paiement">Voir</a>
                        <a href="/manager/paiement/editer?id=<?= base64_encode($paiement['id']) ?>" class="btn btn-edit" title="Éditer ce paiement">Éditer</a>
                        <form action="/manager/paiement/supprimer" method="post" class="manager-inline-form" >
                            <input type="hidden" name="id" value="<?= htmlspecialchars($paiement['id']) ?>">
                            <button type="submit" class="btn btn-delete" title="Supprimer ce paiement">
                                <span aria-hidden="true">&#128465;</span> <span class="sr-only">Supprimer</span>
                            </button>
                        </form>
                    </nav>
                </article>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <p class="manager-empty">Aucun paiement trouvé.</p>
    <?php endif; ?>
</main>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
