<script src="https://cdn.tailwindcss.com"></script>

<?php require_once VIEW_PATH . '/bailleur/layout/header.php'; ?>


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
    <h2 class="text-2xl font-bold mb-6 text-indigo-700">Liste des rendez-vous</h2>

    <?php if (empty($rdvs)): ?>
        <p class="text-gray-500">Aucun rendez-vous trouvé.</p>
    <?php else: ?>
        <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-left">
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Heure</th>
                        <th class="px-4 py-2">client</th>
                        <th class="px-4 py-2">État</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rdvs as $rdv): ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2"><?= isset($rdv['date_rdv']) ? htmlspecialchars($rdv['date_rdv']) : ''; ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($rdv['heur_rdv']); ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($rdv['nom']); ?></td>
                            <td class="px-4 py-2 font-semibold text-sm">
                                <span class="inline-block px-3 py-1 rounded-full
                                    <?= $rdv['statut'] === 'Validé' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?= htmlspecialchars($rdv['statut']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <?php $_SESSION['id_rdv'] = $rdv['id_rdv']; ?>
                                <?php if ($rdv['statut'] === 'Confirme') : ?>

                                    <a href="/voir-rendez-vous"
                                        class="inline-block bg-gray-500 hover:gray-red-600 text-white text-sm px-4 py-2 rounded-md transition shadow-sm">
                                        voir plus
                                    </a>
                                <?php else: ?>
                                    <a href="/Accepter-le-rendez-vous"
                                        onclick="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?');"
                                        class="inline-block bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-md transition shadow-sm">
                                        Accepter
                                    </a>

                                    <a href="/voir-rendez-vous"
                                        class="inline-block bg-gray-500 hover:gray-red-600 text-white text-sm px-4 py-2 rounded-md transition shadow-sm">
                                        voir plus
                                    </a>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>