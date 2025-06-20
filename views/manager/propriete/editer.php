<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>

<link rel="stylesheet" href="<?=ASSET_PATH?>css/manager-editer.css">
<div class="manager-edit-container">
    <h1 class="manager-edit-title">Modifier la propriété</h1>

    <!-- Flash messages -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="manager-edit-flash-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="manager-edit-flash-error">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($proprietes)) : ?>
        <?php $propriete = $proprietes[0]; ?>
        <form action="/manager/propriete/editer" method="POST" enctype="multipart/form-data" class="manager-edit-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($propriete['id']) ?>">
            <div>
                <label>Prix</label>
                <input type="number" name="prix" value="<?= htmlspecialchars($propriete['objet']->getPrix()) ?>">
            </div>
            <div>
                <label>Description</label>
                <textarea name="description"><?= htmlspecialchars($propriete['objet']->getDescription()) ?></textarea>
            </div>
            <div>
                <label>État</label>
                <input type="text" name="etat" value="<?= htmlspecialchars($propriete['objet']->getEtat()) ?>">
            </div>
            <div>
                <label>Option</label>
                <input type="text" name="opt" value="<?= htmlspecialchars($propriete['objet']->getOpt()) ?>">
            </div>
            <div>
                <label>Adresse</label>
                <input type="text" name="adresse" value="<?= htmlspecialchars($propriete['objet']->getAdresse()) ?>">
            </div>
            <button type="submit">Enregistrer</button>
            <a href="/manager/proprietes" class="cancel-link">Annuler</a>
        </form>
    <?php else : ?>
        <div class="manager-edit-flash-error">Propriété introuvable.</div>
    <?php endif; ?>
</div>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
