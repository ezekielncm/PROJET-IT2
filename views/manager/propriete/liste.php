
<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<script src="https://cdn.tailwindcss.com"></script>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Flash messages -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="mb-6 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-300 text-center font-semibold">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="mb-6 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-300 text-center font-semibold">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Titre principal + bouton ajout -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-4">
            <div class="text-center sm:text-left">
                <h1 class="text-4xl font-extrabold text-gray-800">Liste des propriétés</h1>
                <p class="text-lg text-gray-600 mt-4">Visualisez toutes les propriétés gérées par l'agence.</p>
            </div>
            <?php if (isset($_SESSION['id_manager'])): ?>
                <a href="/manager/propriete/ajouter" class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 font-semibold transition text-sm" aria-label="Ajouter une propriété">+ Ajouter une propriété</a>
            <?php endif; ?>
        </div>

        <!-- Grille des propriétés -->
        <?php if (empty($proprietes)): ?>
            <div class="text-center text-gray-500 text-lg py-20">Aucune propriété trouvée.</div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($proprietes as $propriete): ?>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                        <!-- Image de la propriété -->
                        <img src="/assets/images/<?= htmlspecialchars($propriete['objet']->getImage1()) ?>" alt="Propriété" class="w-full h-56 object-cover">

                        <!-- Détails de la propriété -->
                        <div class="p-6">
                            <h5 class="text-2xl font-semibold text-indigo-600 mb-2">
                                <?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> FCFA
                            </h5>
                            <p class="text-gray-700 text-sm mb-2"><?= htmlspecialchars(substr($propriete['objet']->getDescription(), 0, 100)) ?>...</p>
                            <p class="text-gray-500 text-sm mb-1">Mise en : <span class="font-medium"><?= htmlspecialchars($propriete['objet']->getOpt()) ?></span></p>
                            <p class="text-gray-500 text-sm mb-1">Type : <span class="font-medium"><?= htmlspecialchars($propriete['type']->getlibele()) ?></span></p>
                            <p class="text-gray-500 text-sm mb-4">Etat : <span class="font-medium"><?= htmlspecialchars($propriete['objet']->getEtat()) ?></span></p>

                            <div class="flex flex-wrap gap-2 mt-4">
                                <!-- Actions manager -->
                                <?php if (isset($_SESSION['id_manager'])): ?>
                                    <a href="/manager/propriete/voir?id=<?= base64_encode($propriete['id']) ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-xs font-medium transition" aria-label="Voir la propriété">Voir</a>
                                    <a href="/manager/propriete/editer?id=<?= base64_encode($propriete['id']) ?>" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-xs font-medium transition" aria-label="Modifier la propriété">Modifier</a>
                                    <form action="/manager/propriete/supprimer" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($propriete['id']) ?>">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-xs font-medium transition" onclick="return confirm('Voulez-vous vraiment supprimer cette propriété ?');" aria-label="Supprimer la propriété">Supprimer</button>
                                    </form>
                                <?php endif; ?>
                                <!-- Actions client -->
                                <?php if (isset($_SESSION['id_client'])): ?>
                                    <a href="/client/propriete/rdv?id=<?= base64_encode($propriete['id']) ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-xs font-medium transition" aria-label="Demander une visite">Demander une visite</a>
                                    <a href="/client/propriete?id=<?= base64_encode($propriete['id']) ?>" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 text-xs font-medium transition" aria-label="Ajouter aux favoris">Ajouter aux favoris</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php
            $page = $page ?? 1;
            $total_pages = $total_pages ?? 1;
        ?>
        <div class="flex justify-center mt-10">
            <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                <!-- Page précédente -->
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-l-md">Précédent</a>
                <?php else : ?>
                    <span class="px-4 py-2 border border-gray-200 bg-gray-100 text-gray-400 rounded-l-md cursor-not-allowed">Précédent</span>
                <?php endif; ?>

                <!-- Pages numérotées -->
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a href="?page=<?= $i ?>" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-700 hover:bg-gray-50 <?= $i == $page ? 'font-bold bg-indigo-100 text-indigo-700' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <!-- Page suivante -->
                <?php if ($page < $total_pages) : ?>
                    <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-r-md">Suivant</a>
                <?php else : ?>
                    <span class="px-4 py-2 border border-gray-200 bg-gray-100 text-gray-400 rounded-r-md cursor-not-allowed">Suivant</span>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>