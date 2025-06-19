<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<link rel="stylesheet" href="/assets/css/manager.css">
<main class="manager-form-container" aria-label="Ajout agent">
    <div class="manager-form-header">
        <h1>Ajouter un agent</h1>
        <a href="/manager/agents" class="manager-btn manager-btn-secondary">&larr; Retour à la liste</a>
    </div>
    <form action="/manager/agent/ajouter" method="post" class="manager-form">
        <div class="manager-form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="manager-form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="manager-form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="manager-form-group">
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" required pattern="[0-9 +]{8,20}">
        </div>
        <div class="manager-form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
        </div>
        <div class="manager-form-group"><label for="password_confirm">Confirmer le mot de passe</label><input type="password" id="password_confirm" name="password_confirm" required autocomplete="new-password"></div>
        <div class="manager-form-actions">
            <button type="submit" class="manager-btn manager-btn-success">Ajouter</button>
            <a href="/manager/agents" class="manager-btn manager-btn-danger">Annuler</a>
        </div>
    </form>
</main>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>