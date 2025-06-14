<?php require_once VIEW_PATH . '/agent/layout/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes d'achat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="fixed top-5 right-5 z-50">
    <?php if (isset($_SESSION['msg'])): ?>
        <div id="flash-message" class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg animate-slide-in">
            <?= $_SESSION['msg'] ?>
            <?php unset($_SESSION['msg']); ?>
        </div>

        <script>
            // Disparition automatique avec animation
            setTimeout(() => {
                const msg = document.getElementById('flash-message');
                if (msg) {
                    msg.classList.add('animate-slide-out');
                    setTimeout(() => msg.remove(), 500); // Supprime après animation
                }
            }, 3000); // Affiché 3 secondes
        </script>

        <style>
            @keyframes slide-in {
                from {
                    opacity: 0;
                    transform: translateX(100%);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes slide-out {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(100%);
                }
            }

            .animate-slide-in {
                animation: slide-in 0.4s ease-out forwards;
            }

            .animate-slide-out {
                animation: slide-out 0.4s ease-in forwards;
            }
        </style>
    <?php endif; ?>
</div>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">📄 Liste des demandes d'achat</h1>

    <?php if (!empty($ach) && is_array($ach)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-indigo-600 text-white text-sm uppercase text-left">
                    <tr>
                        <th class="px-6 py-3">Image</th>
                        <th class="px-6 py-3">Détails</th>
                        <th class="px-6 py-3">Adresse</th>
                        <th class="px-6 py-3">Prix</th>
                        <th class="px-6 py-3">Date de demande</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                    <?php foreach ($ach as $item): ?>
                        <?php
                            $propriete = $item['propriete'];
                            $achat = $item['achat'];
                        ?>
                        <tr>
                            <td class="px-6 py-4">
                                <img src="/assets/images/<?= htmlspecialchars($propriete->getImage1()) ?>" alt="Propriété"
                                     class="w-24 h-16 object-cover rounded">
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold"><?= ucfirst($propriete->getOpt()) ?> - <?= htmlspecialchars($propriete->getEtat()) ?></p>
                                <p class="text-xs text-gray-500"><?= substr(htmlspecialchars($propriete->getDescription()), 0, 60) ?>...</p>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($propriete->getAdresse()) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= number_format($propriete->getPrix(), 0, ',', ' ') ?> FCFA
                            </td>
                            <td class="px-6 py-4">
                                <?= date('d/m/Y', strtotime($achat->getDateAchat())) ?>
                            </td>
                           
                  <td class="px-6 py-4">
    <?php if ($achat->getIdagent() == 0) : ?>
        <form action="/agent-valider-achat" method="POST">
            <input type="hidden" name="id_propriete" value="<?= $achat->getIdPropriete() ?>">
            <input type="hidden" name="id_client" value="<?= $achat->getIdClient() ?>">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-xs transition duration-200">
                ✅ Valider
            </button>
        </form>
    <?php else: ?>
        
        <div class="flex flex-col gap-1">
            <a href="/reception-de-paiement?id=<?= base64_encode($achat->getIdClient()) ?>"
               class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium px-4 py-2 rounded transition duration-200">
                💰 Paiement
            </a>
            <p class="bg-blue-600 text-white text-xs font-medium px-4 py-2 rounded">
                ✅ Achat validé
            </p>
        </div>
    <?php endif; ?>
</td>


                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-500 text-center mt-20">Aucune demande d'achat pour l'instant.</p>
    <?php endif; ?>
</div>
<?php if ($totalPages > 1): ?>
    <div class="flex justify-center mt-6">
        <nav class="inline-flex space-x-2" aria-label="Pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="px-3 py-2 bg-white border rounded hover:bg-gray-100 text-sm">⬅ Précédent</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>"
                   class="px-4 py-2 rounded border text-sm font-medium
                   <?= $i == $page ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="px-3 py-2 bg-white border rounded hover:bg-gray-100 text-sm">Suivant ➡</a>
            <?php endif; ?>
        </nav>
    </div>
<?php endif; ?>

</body>
</html>
