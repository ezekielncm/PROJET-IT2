<?php
// Vue : Ajouter un bailleur (manager/bailleur/ajouter.php)
// Lien CSS spécifique bailleur
require_once VIEW_PATH . 'manager/layout/header.php';
?>
<div class="bailleur-form-container">
    <h1 class="titre-page">Ajouter un bailleur</h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="POST" action="/manager/bailleur/ajouter" class="bailleur-form">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
        <label for="telephone">Téléphone :</label>
        <input type="text" name="telephone" id="telephone" required>
        <button type="submit" class="btn btn-add">Ajouter</button>
        <a href="/manager/bailleur/liste" class="btn btn-back">Annuler</a>
    </form>
</div>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>