
<?php
// Vue : Liste des clients pour le manager UrbanHome
require_once __DIR__ . '/../layout/header.php';
?>
<main class="manager-listes">
    <h1 class="manager-listes-title">Clients de la plateforme</h1>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="flash-message success" role="status"> <?= htmlspecialchars($_SESSION['success']) ?> </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-message error" role="alert"> <?= htmlspecialchars($_SESSION['error']) ?> </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="manager-listes-sections">
        <section class="manager-listes-block">
            <div class="manager-listes-block-header" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
                <h2 style="margin:0;">Clients</h2>
                <a href="/manager/client/add" class="manager-btn manager-btn-success" style="font-size:1rem;"><span aria-hidden="true">➕</span> Ajouter un client</a>
            </div>
            <div class="manager-cards">
                <?php if (!empty($clients)) : ?>
                    <?php foreach ($clients as $client) : ?>
                        <div class="manager-card" tabindex="0" aria-label="Fiche client">
                            <div class="manager-card-header">
                                <span class="manager-card-title"><?= htmlspecialchars($client['objet']->getNom()) ?> <?= htmlspecialchars($client['objet']->getPrenom()) ?></span>
                            </div>
                            <div class="manager-card-body">
                                <p><span class="manager-label">Email :</span> <b><?= htmlspecialchars($client['objet']->getEmail()) ?></b></p>
                                <p><span class="manager-label">Téléphone :</span> <b><?= htmlspecialchars($client['objet']->getNumero_telephone()) ?></b></p>
                                <p><span class="manager-label">Adresse :</span> <b><?= htmlspecialchars($client['objet']->getAdresse()) ?></b></p>
                            </div>
                            <div class="manager-card-actions">
                                <a href="/manager/client/voir?id=<?= urlencode($client['id']) ?>" class="manager-btn manager-btn-primary" title="Voir le client"><span aria-hidden="true">👁️</span> Voir</a>
                                <a href="/manager/client/edit?id=<?= urlencode($client['id']) ?>" class="manager-btn manager-btn-success" title="Éditer le client"><span aria-hidden="true">✏️</span> Éditer</a>
                                <a href="/manager/client/delete?id=<?= urlencode($client['id']) ?>" class="manager-btn manager-btn-danger" title="Supprimer le client" onclick="return confirm('Supprimer ce client ?');"><span aria-hidden="true">🗑️</span> Supprimer</a>
                                <a href="/manager/client/affecter?client_id=<?= urlencode($client['id']) ?>" class="manager-btn manager-btn-secondary" title="Affecter à un agent"><span aria-hidden="true">🤝</span> Affecter à un agent</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="manager-empty">Aucun client trouvé.</p>
                <?php endif; ?>
            </div>
            <?php if (isset($totalPages) && $totalPages > 1): ?>
            <nav class="manager-pagination" aria-label="Pagination des clients">
                <ul>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li>
                            <a href="?page=<?= $i ?>" class="manager-btn<?= ($i == $page) ? ' active' : '' ?>" aria-current="<?= ($i == $page) ? 'page' : false ?>">Page <?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
