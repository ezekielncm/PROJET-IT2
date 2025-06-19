<?php
// Vue : Éditer un bailleur (manager/bailleur/editer.php)
// Variable attendue : $bailleur (objet Bailleur)
// Lien CSS spécifique bailleur
require_once VIEW_PATH . 'manager/layout/header.php';
?>
<div class="bailleur-form-container">
    <h1 class="titre-page">Éditer le bailleur</h1>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (!empty($bailleur)): ?>
        <form method="POST" action="/manager/bailleur/editer?id_bailleur=<?= $bailleur->getId() ?>" class="bailleur-form">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($bailleur->getNom()) ?>" required>
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($bailleur->getPrenom()) ?>" required>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($bailleur->getEmail()) ?>" required>
            <label for="telephone">Téléphone :</label>
            <input type="text" name="telephone" id="telephone" value="<?= htmlspecialchars($bailleur->getTelephone()) ?>" required>
            <button type="submit" class="btn btn-edit">Enregistrer</button>
            <a href="/manager/bailleur/liste" class="btn btn-back">Annuler</a>
        </form>
    <?php else: ?>
        <p>Bailleur introuvable.</p>
    <?php endif; ?>
</div>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>