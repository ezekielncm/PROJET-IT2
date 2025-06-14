<?php require_once VIEW_PATH . '/bailleur/layout/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes d'achat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">



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
                                 <?php if($achat->getIdBailleur()==0) :?>
                                <form action="/bailleur/validerAchat" method="POST">
                                    <input type="hidden" name="id_propriete" value="<?= $achat->getIdPropriete() ?>">
                                    <input type="hidden" name="id_client" value="<?= $achat->getIdClient() ?>">
                                    <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-xs">
                                        ✅ Valider
                                    </button>
                                </form>
                                <?php else: ?>
                                <p class="bg-blue-600  text-white px-4 py-2 rounded text-xs">✅ achat validé.</p>
                            <?php endif;?>
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

</body>
</html>
