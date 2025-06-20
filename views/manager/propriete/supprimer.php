<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<div class="max-w-xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6 text-red-600">Supprimer la propriété</h1>
    <?php if (!empty($propriete)) : ?>
        <div class="bg-white rounded-xl shadow p-6">
            <p>Êtes-vous sûr de vouloir supprimer cette propriété ?</p>
            <ul class="mb-4 mt-2">
                <li><b>Type :</b> <?= htmlspecialchars($propriete['type']->getlibele()) ?></li>
                <li><b>Adresse :</b> <?= htmlspecialchars($propriete['objet']->getAdresse()) ?></li>
                <li><b>Prix :</b> <?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> FCFA</li>
            </ul>
            <form action="/manager/propriete/supprimer" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($propriete['id']) ?>">
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">Confirmer la suppression</button>
                <a href="/manager/proprietes" class="ml-4 text-gray-600">Annuler</a>
            </form>
        </div>
    <?php else : ?>
        <div class="text-red-500">Propriété introuvable.</div>
    <?php endif; ?>
</div>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
