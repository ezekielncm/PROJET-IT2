<?php require_once VIEW_PATH . 'manager/layout/navbar.php'; ?>
<link rel="stylesheet" href="/assets/css/manager.css">
<main class="manager-detail-container" aria-label="Détail agent">
    <header class="manager-detail-header">
        <h1>Détail de l'agent</h1>
        <a href="/manager/agent/liste" class="manager-btn manager-btn-secondary">&larr; Retour à la liste</a>
    </header>
    <?php if (isset($agent)): ?>
        <section class="manager-detail-card" tabindex="0" aria-labelledby="agent-nom">
            <h2 id="agent-nom" class="manager-detail-title">
                <?= htmlspecialchars($agent->getNom()) ?> <?= htmlspecialchars($agent->getPrenom()) ?>
            </h2>
            <ul class="manager-detail-list">
                <li><span class="manager-label">Username :</span> <b><?= htmlspecialchars($agent->getUsername()) ?></b></li>
                <li><span class="manager-label">Téléphone :</span> <b><?= htmlspecialchars($agent->getTelephone()) ?></b></li>
            </ul>
            <nav class="manager-detail-actions" aria-label="Actions agent">
                <a href="/manager/agent/editer?id=<?= base64_encode($agent->getUsername()) ?>" class="manager-btn manager-btn-warning" title="Éditer">
                    &#9998; Éditer
                </a>
                <form action="/manager/agent/supprimer" method="post" class="manager-inline-form" onsubmit="return confirm('Supprimer cet agent ?');">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($agent->getUsername()) ?>">
                    <button type="submit" class="manager-btn manager-btn-danger" title="Supprimer">
                        &#128465; Supprimer
                    </button>
                </form>
            </nav>
        </section>
    <?php else: ?>
        <p class="manager-empty">Agent introuvable.</p>
    <?php endif; ?>
</main>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
