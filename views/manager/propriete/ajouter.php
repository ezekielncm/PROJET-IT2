<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<link rel="stylesheet" href="<?=ASSET_PATH?>css/manager-editer.css">
<div class="manager-edit-container">
    <h1 class="manager-edit-title">Ajouter une propriété</h1>

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

    <form action="/manager/propriete/ajouter" method="POST" enctype="multipart/form-data" class="manager-edit-form">
        <div>
            <label>Prix</label>
            <input type="number" name="prix" required>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description" required></textarea>
        </div>
        <div>
            <label>État</label>
            <input type="text" name="etat" required>
        </div>
        <div>
            <label>Option</label>
            <input type="text" name="opt" required>
        </div>
        <div>
            <label>Adresse</label>
            <input type="text" name="adresse" required>
        </div>
        <div>
            <label>Image principale</label>
            <input type="file" name="image1" required>
        </div>
        <button type="submit">Ajouter</button>
        <a href="/manager/proprietes" class="cancel-link">Annuler</a>
    </form>
</div>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
