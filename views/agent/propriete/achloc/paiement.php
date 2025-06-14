<?php require_once VIEW_PATH . '/agent/layout/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réception de Paiement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<?php if (!empty($client) && !empty($propriete) && !empty($typepaiment)): ?>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Détails de l'achat</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">👤 <span class="font-medium">Client :</span> <?= htmlspecialchars($propriete['prenom_client']) ?> <?= htmlspecialchars($propriete['nom_client']) ?></p>
                <p class="text-sm text-gray-600 mb-1">📧 <span class="font-medium">Email :</span> <?= htmlspecialchars($propriete['email_client']) ?></p>
                <p class="text-sm text-gray-600 mb-1">📞 <span class="font-medium">Téléphone :</span> <?= htmlspecialchars($propriete['telephone_client']) ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">🏠 <span class="font-medium">Propriété :</span> <?= ucfirst($propriete['propriete']->getOpt()) ?> - <?= htmlspecialchars($propriete['propriete']->getEtat()) ?></p>
                <p class="text-sm text-gray-600 mb-1">📍 <span class="font-medium">Adresse :</span> <?= htmlspecialchars($propriete['propriete']->getAdresse()) ?></p>
                <p class="text-sm text-gray-600 mb-1">💰 <span class="font-medium">Prix :</span> <?= number_format($propriete['propriete']->getPrix(), 0, ',', ' ') ?> FCFA</p>
            </div>
        </div>

        <form action="/valider-paiement" method="POST">
            <input type="hidden" name="id_client" value="<?= htmlspecialchars($propriete['id_client']) ?>">
            <input type="hidden" name="id_propriete" value="<?= htmlspecialchars($propriete['id_propriete']) ?>">
            <input type="hidden" name="id_bailleur" value="<?= htmlspecialchars($propriete['propriete']->getIdbailleur()) ?>">
             <input type="hidden" name="montant_pro" value="<?= htmlspecialchars( $propriete['propriete']->getPrix()) ?>">
            <div class="mb-4">
                <label for="montant" class="block text-sm font-medium text-gray-700 mb-1">💳 Montant reçu</label>
                <input type="text" name="montant" id="montant" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
          
            <div class="mb-4">
    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">💳 Type de Paiement</label>
    <select name="type" id="type" required
            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">-- Sélectionner un moyen de paiement --</option>
        <?php foreach ($typepaiment as $type): ?>
            <option value="<?= $type['id_moyen_paiement'] ?>"><?= htmlspecialchars($type['Libelle']) ?></option>
        <?php endforeach; ?>
    </select>
</div>

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm transition duration-200">
                ✅ Confirmer le Paiement
            </button>
        </form>
    </div>
<?php else: ?>
    <p class="text-red-500 text-center">❌ Aucune information disponible pour ce paiement.</p>
<?php endif; ?>

</body>
</html>
