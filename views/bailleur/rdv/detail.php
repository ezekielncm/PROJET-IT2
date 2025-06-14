<script src="https://cdn.tailwindcss.com"></script>
<?php require_once VIEW_PATH . '/bailleur/layout/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-indigo-700">Détail du rendez-vous</h2>

    <?php if (isset($rdv)): ?>
        <div class="bg-white shadow-xl rounded-lg p-6 max-w-2xl mx-auto">
            <div class="mb-4 space-y-2">
                <p class="text-gray-600"><span class="font-semibold">Date :</span> <?= htmlspecialchars($rdv['date_rdv']) ?></p>
                <p class="text-gray-600"><span class="font-semibold">Heure :</span> <?= htmlspecialchars($rdv['heur_rdv']) ?></p>
                <p class="text-gray-600"><span class="font-semibold">Client :</span> <?= htmlspecialchars($rdv['nom']) ?></p>
                <p class="text-gray-600"><span class="font-semibold">Téléphone :</span> <?= htmlspecialchars($rdv['telephone']) ?></p>
                <p class="text-gray-600"><span class="font-semibold">Statut :</span>
                    <span class="inline-block px-3 py-1 rounded-full 
                        <?= $rdv['statut'] === 'Validé' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                        <?= htmlspecialchars($rdv['statut']) ?>
                    </span>
                </p>
                <p class="text-gray-600"><span class="font-semibold">Description :</span> <?= htmlspecialchars($rdv['descriptions']) ?></p>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="/voir-mes-demande-de-visite" class="text-sm text-indigo-600 hover:underline">
                    ← Retour à la liste
                </a>

                <form action="/changer-statut-rdv" method="POST" class="flex items-center gap-4">
                    <input type="hidden" name="id_rdv" value="<?= htmlspecialchars($rdv['id_rdv']) ?>">

                    <select name="nouveau_statut" class="border border-gray-300 rounded px-3 py-1 text-sm">
                        <option value="">-- Sélectionnez un statut --</option>
                        <?php foreach ($statuts as $statut): ?>
                            
                                <option value="<?= $statut['id_statut'] ?>" 
                                    <?= $rdv['id_statut'] == $statut['id_statut'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($statut['statut']) ?>
                                </option>
                         
                        <?php endforeach; ?>
                    </select>

                    <button type="submit"
                        onclick="return confirm('Confirmer le changement de statut ?');"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition">
                        Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <p class="text-gray-500 text-center">Aucun détail de rendez-vous trouvé.</p>
    <?php endif; ?>
</div>

