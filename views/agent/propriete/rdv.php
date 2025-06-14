<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<?php require_once VIEW_PATH . 'agent/layout/header.php'; ?>

<main class="p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Liste des rendez-vous</h2>

    <?php if (empty($listes_rdv)): ?>
        <div class="text-center text-gray-600 text-lg">
            Aucun rendez-vous prévu pour le moment.
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="text-left px-6 py-3">Client</th>
                        <th class="text-left px-6 py-3">Bailleur</th>
                        <th class="text-left px-6 py-3">Date RDV</th>
                        <th class="text-left px-6 py-3">Heure RDV</th>
                        <th class="text-left px-6 py-3">Etat RDV</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach ($listes_rdv as $rdv): ?>
                        <tr class="border-b">
                            <td class="px-6 py-4"><?= htmlspecialchars($rdv['nomclient']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($rdv['nombailleur']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($rdv['date_rdv']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($rdv['heur_rdv']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($rdv['etat']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center space-x-2">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="px-3 py-1 rounded border 
                    <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
