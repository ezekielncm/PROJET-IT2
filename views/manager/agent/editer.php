<?php require_once VIEW_PATH . 'manager/layout/navbar.php'; ?>
<link rel="stylesheet" href="/assets/css/manager.css">
<main class="manager-form-container" aria-label="Édition agent">
    <header class="manager-form-header">
        <h1>Éditer l'agent</h1>
        <a href="/manager/agent/liste" class="manager-btn manager-btn-secondary">&larr; Retour à la liste</a>
    </header>
    <?php if (isset($agent)): ?>
        <form action="/manager/agent/editer" method="post" class="manager-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($agent->getUsername()) ?>">
            <div class="manager-form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($agent->getNom()) ?>" required>
            </div>
            <div class="manager-form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($agent->getPrenom()) ?>" required>
            </div>
            <div class="manager-form-group">
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($agent->getTelephone()) ?>" required pattern="[0-9 +]{8,20}">
            </div>
            <div class="manager-form-group">
                <label for="password">Nouveau mot de passe <span class="manager-form-note">(laisser vide pour ne pas changer)</span></label>
                <input type="password" id="password" name="password" autocomplete="new-password">
            </div>
            <div class="manager-form-actions">
                <button type="submit" class="manager-btn manager-btn-success">Enregistrer</button>
                <a href="/manager/agent/liste" class="manager-btn manager-btn-danger">Annuler</a>
            </div>
        </form>
    <?php else: ?>
        <p class="manager-empty">Agent introuvable.</p>
    <?php endif; ?>
</main>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
