<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>

<link rel="stylesheet" href="/assets/css/manager.css">
<main class="manager-list-container" aria-label="Liste des agents">
    <div class="manager-list-header">
        <h1 tabindex="0">Liste des agents</h1>
        <a href="/manager/agent/ajouter" class="manager-btn manager-btn-success" title="Ajouter un nouvel agent">
            <span aria-hidden="true">&#43;</span> Ajouter un agent
        </a>
    </div>
    <?php if (!empty($agents)): ?>
        <section class="manager-card-list" aria-label="Cartes agents">
            <?php foreach ($agents as $agent): ?>
                <article class="manager-card" tabindex="0" aria-labelledby="agent-<?= htmlspecialchars($agent->id_agent) ?>-nom">
                    <div class="manager-card-content">
                        <h2 id="agent-<?= htmlspecialchars($agent->id_agent) ?>-nom" class="manager-card-title">
                            <?= htmlspecialchars($agent->getNom()) ?> <?= htmlspecialchars($agent->getPrenom()) ?>
                        </h2>
                        <ul class="manager-card-details">
                            <li><span class="manager-label">Username :</span> <b><?= htmlspecialchars($agent->getUsername()) ?></b></li>
                            <li><span class="manager-label">Téléphone :</span> <b><?= htmlspecialchars($agent->getTelephone()) ?></b></li>
                        </ul>
                    </div>
                    <nav class="manager-card-actions" aria-label="Actions agent">
                        <a href="/manager/agent/voir?id=<?= base64_encode($agent->id_agent) ?>" class="manager-btn manager-btn-primary" title="Voir les détails de l'agent">
                            Voir
                        </a>
                        <a href="/manager/agent/editer?id=<?= base64_encode($agent->id_agent) ?>" class="manager-btn manager-btn-warning" title="Éditer cet agent">
                            Éditer
                        </a>
                        <form action="/manager/agent/supprimer" method="post" class="manager-inline-form" >
                            <input type="hidden" name="id" value="<?= htmlspecialchars($agent->id_agent) ?>">
                            <button type="submit" class="manager-btn manager-btn-danger" title="Supprimer cet agent">
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