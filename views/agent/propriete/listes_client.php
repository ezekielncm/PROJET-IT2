<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Clients affectés</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<?php require_once VIEW_PATH . 'agent/layout/header.php'; ?>

<main class="p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Clients affectés</h2>

    <?php if (empty($clients)): ?>
        <div class="text-center text-gray-600 text-lg">
            Aucun client affecté pour le moment.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($clients as $client): ?>
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($client['nom']) ?> <?= htmlspecialchars($client['prenom']) ?></h3>
                    <p class="text-gray-600">Email : <?= htmlspecialchars($client['email']) ?></p>
                    <p class="text-gray-600">Téléphone : <?= htmlspecialchars($client['telephone']) ?></p>
                    <p class="text-gray-500 text-sm mt-2">Adresse : <?= htmlspecialchars($client['adresse']) ?></p>
                </div>
            <?php endforeach; ?>
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
