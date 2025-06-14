<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Propriétés à valider</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<?php require_once VIEW_PATH . 'agent/layout/header.php'; ?>

<main class="p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Propriétés en attente de validation</h2>

  <?php if (empty($proprietes)): ?>
        <div class="text-center text-gray-600 text-lg">Aucune propriété en attente.</div>
    <?php else: ?>
       
        < class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($proprietes as $data): ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <img src="/assets/images/<?= htmlspecialchars($data['objet']->getImage1()) ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($data['type']->getlibele()) ?></h3>
                        <p class="text-gray-600 mb-1"><?= htmlspecialchars($data['objet']->getAdresse()) ?></p>
                        <p class="text-green-600 font-bold"><?= number_format($data['objet']->getPrix(), 0, ',', ' ') ?> FCFA</p>
                        <p class="text-sm text-gray-500 mt-2"><?=  substr(htmlspecialchars($data['objet']->getDescription()),0,100) ?></p>
                        
                        <form action="/valider-propriete" method="POST" class="mt-4">
                            <input type="hidden" name="id_propriete" value="<?= base64_encode($data['id_propriete']) ?>">
                            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                                Valider cette propriété
                            </button>
                        </form>
                    </div>
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
