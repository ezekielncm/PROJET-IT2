<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<main class="bailleurs-container" aria-label="Liste des agents">
    <div class="manager-list-header">
        <h1 tabindex="0">Liste des agents</h1>
        <a href="/manager/agent/ajouter" class="btn btn-add" title="Ajouter un agent">
            <span aria-hidden="true">&#43;</span> Ajouter un agent
        </a>
    </div>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="flash-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (!empty($agents)): ?>
        <section class="bailleurs-list" aria-label="Cartes agents">
            <?php foreach ($agents as $agent): ?>
                <article class="bailleur-card" tabindex="0" aria-labelledby="agent-<?= htmlspecialchars($agent['id']) ?>-nom">
                    <div class="bailleur-info">
                        <h2 id="agent-<?= htmlspecialchars($agent['id']) ?>-nom" class="bailleur-nom">
                            <?= htmlspecialchars($agent['objet']->getNom()) ?> <?= htmlspecialchars($agent['objet']->getPrenom()) ?>
                        </h2>
                        <ul class="bailleur-details">
                            <li><span class="bailleur-label">Username :</span> <b><?= htmlspecialchars($agent['objet']->getUsername()) ?></b></li>
                            <li><span class="bailleur-label">Téléphone :</span> <b><?= htmlspecialchars($agent['objet']->getTelephone()) ?></b></li>
                        </ul>
                    </div>
                    <nav class="bailleur-actions" aria-label="Actions agent">
                        <a href="/manager/agent/voir?id=<?= base64_encode($agent['id']) ?>" class="btn btn-view" title="Voir les détails de l'agent">Voir</a>
                        <a href="/manager/agent/editer?id=<?= base64_encode($agent['id']) ?>" class="btn btn-edit" title="Éditer cet agent">Éditer</a>
                        <form action="/manager/agent/supprimer" method="post" class="manager-inline-form" >
                            <input type="hidden" name="id" value="<?= htmlspecialchars($agent['id']) ?>">
                            <button type="submit" class="btn btn-delete" title="Supprimer cet agent">
                                <span aria-hidden="true">&#128465;</span> <span class="sr-only">Supprimer</span>
                            </button>
                        </form>
                    </nav>
                </article>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <p class="manager-empty">Aucun agent trouvé.</p>
    <?php endif; ?>
</main>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>